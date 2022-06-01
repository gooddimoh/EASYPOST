<?php

declare(strict_types=1);

namespace App\Controller\Api\Company;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\Company\Controller\CompanyService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

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
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     *
     * @param CompanyService                $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        CompanyService $service,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->service = $service;
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
        $companies = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'pagination' => $this->paginationSerializer->toArray($companies),
                    'items' => $companies->getItems(),
                    'columns' => $this->service->getTableColumns()
                ]
            ]
        );
    }

    /**
     * @Route("/balance", name=".balance")
     *
     * @return Response
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function balance(): Response
    {
        return $this->json(
            [
                'status' => true,
                'message' => [
                    'balance' => $this->service->getBalance()
                ]
            ]
        );
    }

    /**
     * @Route("/list", name=".list")
     *
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function list(Request $request): Response
    {
        $companies = $this->service->getList(
            $request->query->get('label'),
            $request->query->get('id', ''),
        );

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'items' => $companies,
                ]
            ]
        );
    }
}
