<?php

declare(strict_types=1);

namespace App\Controller\Api\Company;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Services\BusinessLogicService;
use App\Infrastructure\Services\Resizer\ImageResizer;
use App\Model\Company\UseCase\Company\Update\Command as UpdateCommand;
use App\Model\Company\UseCase\Company\Update\Handler as UpdateHandler;
use App\Model\Company\UseCase\Company\LinkPackage\Command as LinkPackageCommand;
use App\Model\Company\UseCase\Company\LinkPackage\Handler as LinkPackageHandler;
use App\Model\Company\UseCase\Company\Delete\Command as DeleteCommand;
use App\Model\Company\UseCase\Company\Delete\Handler as DeleteHandler;
use App\Services\Auth\ManualLoginUserService;
use App\Services\Permission\PermissionService;
use Gumlet\ImageResizeException;
use League\Flysystem\FileExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/companies", name="company")
 *
 * Class EditController
 *
 * @package App\Controller\Api\Company
 */
class EditController extends AbstractController
{
    /**
     * @var PermissionService
     */
    private PermissionService $permissionService;

    /**
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

//    /**
//     * @Route("/create", name=".create", methods={"POST"})
//     *
//     * @param Request       $request
//     * @param CreateCommand $command
//     * @param CreateHandler $handler
//     * @param ImageResizer  $imageResizer
//     *
//     * @return Response
//     * @throws FileExistsException
//     * @throws ImageResizeException
//     * @throws \Exception
//     */
//    public function create(
//        Request       $request,
//        CreateCommand $command,
//        CreateHandler $handler,
//        ImageResizer  $imageResizer
//    ): Response {
//        if ($photo = $request->files->get('photo')) {
//            $file = $imageResizer->setImage($photo)->resizeToBestFit()->upload();
//            $command->photo = $file->getPath() . '/' . $file->getName();
//        }
//
//        $user = $handler->handle($command);
//
//        return $this->json([
//            'status' => true,
//            'message' => ['id' => $user->getId()->getValue()],
//        ]);
//    }

    /**
     * @Route("/{id}/edit", name=".edit", methods={"POST"})
     *
     * @param Request       $request
     * @param UpdateCommand $command
     * @param UpdateHandler $handler
     * @param ImageResizer  $imageResizer
     *
     * @return Response
     * @throws FileExistsException
     * @throws ImageResizeException
     * @throws \Exception
     */
    public function edit(
        Request       $request,
        UpdateCommand $command,
        UpdateHandler $handler,
        ImageResizer  $imageResizer
    ): Response {
        if (!$this->permissionService->hasRoleAccess('ROLE_COMPANY_OWNER', $command->id)) {
            throw new InvalidRequestParameter('You do not have permission to perform the action.');
        }

        if ($photo = $request->files->get('photo')) {
            $file = $imageResizer->setImage($photo)->resizeToBestFit()->upload();

            $command->photo = $file->getPath() . '/' . $file->getName();
        }

        $user = $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => ['id' => $user->getId()->getValue()],
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"DELETE"})
     *
     * @param string        $id
     * @param DeleteCommand $command
     * @param DeleteHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function delete(string $id, DeleteCommand $command, DeleteHandler $handler): Response
    {
        if (!$this->permissionService->hasRoleAccess('ROLE_COMPANY_OWNER', $command->id)) {
            throw new InvalidRequestParameter('You do not have permission to perform the action.');
        }

        $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => ['id' => $id],
        ]);
    }

    /**
     * @Route("/link-package", name=".link-package", methods={"POST"})
     *
     * @param BusinessLogicService   $businessLogicService
     * @param ManualLoginUserService $manualLoginUserService
     * @param LinkPackageCommand     $command
     * @param LinkPackageHandler     $handler
     *
     * @return Response
     */
    public function linkPackage(
        BusinessLogicService   $businessLogicService,
        ManualLoginUserService $manualLoginUserService,
        LinkPackageCommand     $command,
        LinkPackageHandler     $handler
    ): Response {
        $userIdentity = $this->getUser();
        $command->id = $userIdentity->getCompany();

        $businessLogicService->transactional(fn() => $handler->handle($command));

        $manualLoginUserService->refreshUserIdentity($userIdentity);

        return $this->json([
            'status' => true,
            'message' => ['id' => $command->package],
        ]);
    }
}
