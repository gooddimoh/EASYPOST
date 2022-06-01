<?php

declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Services\Resizer\ImageResizer;
use App\Model\Company\UseCase\Company\Registration\Update\Command as CompanyUpdateCommand;
use App\Model\Label\UseCase\AddressBook\Create\Command as AddressBookCreateCommand;
use App\Model\User\UseCase\User\Confirm\Command as UserConfirmCommand;
use App\Model\User\UseCase\User\Create\Command as CreateCommand;
use App\Model\User\UseCase\User\Create\Handler as CreateHandler;
use App\Model\User\UseCase\User\Update\Command as UpdateCommand;
use App\Model\User\UseCase\User\Update\Handler as UpdateHandler;
use App\Model\User\UseCase\User\Delete\Command as DeleteCommand;
use App\Model\User\UseCase\User\Delete\Handler as DeleteHandler;
use App\ModelServices\FullRegistrationHandler;
use App\Services\Auth\ManualLoginUserService;
use App\Services\Permission\PermissionService;
use Doctrine\DBAL\Exception;
use Gumlet\ImageResizeException;
use League\Flysystem\FileExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/users", name="user")
 *
 * Class EditController
 *
 * @package App\Controller\Api\User
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

    // /**
    //  * @Route("/create", name=".create", methods={"POST"})
    //  *
    //  * @param Request                $request
    //  * @param ManualLoginUserService $manualLoginUserService
    //  * @param CreateCommand          $command
    //  * @param CreateHandler          $handler
    //  * @param ImageResizer           $imageResizer
    //  *
    //  * @return Response
    //  * @throws FileExistsException
    //  * @throws ImageResizeException
    //  * @throws Exception
    //  * @throws \Exception
    //  */
    // public function create(
    //     Request                $request,
    //     ManualLoginUserService $manualLoginUserService,
    //     CreateCommand          $command,
    //     CreateHandler          $handler,
    //     ImageResizer           $imageResizer
    // ): Response {
    //     if ($photo = $request->files->get('photo')) {
    //         $file = $imageResizer->setImage($photo)->resizeToBestFit()->upload();
    //         $command->photo = $file->getPath() . '/' . $file->getName();
    //     }
    //
    //     $user = $handler->handle($command);
    //
    //     $message = [
    //         'id' => $user->getId()->getValue(),
    //     ];
    //
    //     if (!$this->getUser()) {
    //         $manualLoginUserService->login($request, $user->getEmail()->getValue());
    //
    //         $message['redirect'] = $this->generateUrl('label.index');
    //     }
    //
    //     return $this->json([
    //         'status' => true,
    //         'message' => $message,
    //     ]);
    // }

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
        if (!$this->permissionService->hasUserAccess($command->id)) {
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
        if (!$this->permissionService->hasRoleAccess('ROLE_ADMIN')) {
            throw new InvalidRequestParameter('You do not have permission to perform the action.');
        }

        $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => ['id' => $id],
        ]);
    }

    /**
     * @Route("/full-registration", name=".full-registration", methods={"POST"})
     *
     * @param UserConfirmCommand       $userConfirmCommand
     * @param CompanyUpdateCommand     $companyUpdateCommand
     * @param AddressBookCreateCommand $addressBookCreateCommand
     * @param FullRegistrationHandler  $registrationHandler
     *
     * @return Response
     * @throws \Throwable
     */
    public function fullRegistration(
        UserConfirmCommand       $userConfirmCommand,
        CompanyUpdateCommand     $companyUpdateCommand,
        AddressBookCreateCommand $addressBookCreateCommand,
        FullRegistrationHandler  $registrationHandler
    ): Response {
        $companyUpdateCommand->companyId = $this->getUser()->getCompany();
        $userConfirmCommand->id = $this->getUser()->getId();

        $user = $registrationHandler->handle($userConfirmCommand, $companyUpdateCommand, $addressBookCreateCommand);

        return $this->json([
            'status' => true,
            'message' => [
                'id' => $user->getId()->getValue()
            ]
        ]);
    }
}
