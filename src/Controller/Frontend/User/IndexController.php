<?php

declare(strict_types=1);

namespace App\Controller\Frontend\User;

use App\Export\User\UserExport;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Model\User\Entity\User\User;
use App\Services\Company\Controller\CompanyService;
use App\Services\Export\XlsxService;
use App\Services\Package\Controller\PackageService;
use App\Services\User\Controller\UserService;
use App\Services\Label\Controller\LabelService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/users", name="user")
 */
class IndexController extends AbstractController
{
    /**
     * @var UserService
     */
    private UserService $service;

    /**
     * @var CompanyService
     */
    private CompanyService $companyService;

    /**
     * @var LabelService
     */
    private LabelService $labelService;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     *
     * @param UserService                   $service
     * @param CompanyService                $companyService
     * @param LabelService                  $labelService
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        UserService                   $service,
        CompanyService                $companyService,
        LabelService                  $labelService,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->service = $service;
        $this->companyService = $companyService;
        $this->labelService = $labelService;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        $cost = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->render(
            'app/user/index.html.twig',
            [
                'pagination' => $this->paginationSerializer->toArray($cost),
                'items' => $cost->getItems(),
                'columns' => $this->service->getTableColumns(),
            ]
        );
    }

//    /**
//     * @Route("/create", name=".create")
//     *
//     * @return Response
//     */
//    public function create(): Response
//    {
//        return $this->render('app/user/create.html.twig');
//    }

    /**
     * @Route("/{id}", name=".show")
     *
     * @param User           $user
     * @param Request        $request
     * @param PackageService $packageService
     *
     * @return Response
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function show(User $user, Request $request, PackageService $packageService): Response
    {
        $tab = $request->query->get('tab');

        if ($tab === 'package') {
            $items = $packageService->getItems(new PaginationRequest($request->query->all()));
            $columns = $packageService->getTableColumns();
        } else {
            $items = $this->labelService->getItems(
                new PaginationRequest(
                    ['filter' => ['userId' => $user->getId()->getValue()]]
                )
            );

            $columns = $this->labelService->getTableColumns();
        }


        $company = $this->companyService->getList(null, $user->getCompany()->getValue());

        return $this->render(
            'app/user/show.html.twig',
            [
                'user' => $user,
                'company' => $company[0],
                'pagination' => $this->paginationSerializer->toArray($items),
                'items' => $items->getItems(),
                'columns' => $columns
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     *
     * @param User $user
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function edit(User $user): Response
    {
        $company = $this->companyService->getList(null, $user->getCompany()->getValue());

        return $this->render(
            'app/user/edit.html.twig',
            [
                'user' => $user,
                'company' => $company[0],
            ]
        );
    }

    /**
     * @Route("/export/my-profile", name=".export.my-profile", methods={"GET"})
     *
     * @param XlsxService $service
     * @param UserExport  $userExport
     *
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(XlsxService $service, UserExport $userExport): Response
    {
        $userExport->setFilters(new PaginationRequest(['filter' => ['id' => $this->getUser()->getId()]]));
        $file = $service->generate($userExport);

        return $this->file($file->getTempFile(), $file->getFileName(), ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/{id}/changePassword", name=".changePassword")
     *
     * @return Response
     */
    public function changePassword(): Response
    {
        return $this->render('app/user/changePassword.html.twig');
    }
}
