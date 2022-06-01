<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Company;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Model\Company\Entity\Company\Company;
use App\Services\Company\Controller\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use App\Services\User\Controller\UserService;

/**
 * @Route("/companies", name="company")
 */
class IndexController extends AbstractController
{
    /**
     * @var CompanyService
     */
    private CompanyService $service;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     * @param CompanyService $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        CompanyService $service,
        UserService $userService,
        PaginationSerializerInterface $paginationSerializer
    )
    {
        $this->service = $service;
        $this->userService = $userService;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index")
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        $companies = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->render('/app/company/index.html.twig', [
            'pagination' => $this->paginationSerializer->toArray($companies),
            'items' => $companies->getItems(),
            'columns' => $this->service->getTableColumns()
        ]);
    }

//    /**
//     * @Route("/create", name=".create")
//     *
//     * @return Response
//     */
//    public function create(): Response
//    {
//        return $this->render('app/company/create.html.twig');
//    }

    /**
     * @Route("/{id}", name=".show")
     *
     * @param Company $company
     * @return Response
     */
    public function show(Company $company): Response
    {

        $users = $this->userService->getItems(new PaginationRequest(
            ['filter' => ['companyId' => $company->getId()->getValue()]]
        ));

        return $this->render('app/company/show.html.twig', [
            'company' => $company,
            'pagination' => $this->paginationSerializer->toArray($users),
            'items' => $users->getItems(),
            'columns' => $this->userService->getTableColumns(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     *
     * @param Company $company
     * @return Response
     */
    public function edit(Company $company): Response
    {
        return $this->render('app/company/edit.html.twig', [
            'company' => $company
        ]);
    }
}
