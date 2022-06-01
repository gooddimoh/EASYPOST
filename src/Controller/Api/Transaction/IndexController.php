<?php

declare(strict_types=1);

namespace App\Controller\Api\Transaction;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\Transaction\Controller\TransactionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/transactions", name="transaction")
 *
 * Class IndexController
 * @package App\Controller\Api\User
 */
class IndexController extends AbstractController
{
    /**
     * @var TransactionService
     */
    private TransactionService $service;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     * @param TransactionService $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        TransactionService $service,
        PaginationSerializerInterface $paginationSerializer
    )
    {
        $this->service = $service;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index", methods={"GET"})
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        $companies = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->json([
            'status' => true,
            'message' => [
                'pagination' => $this->paginationSerializer->toArray($companies),
                'items' => $companies->getItems(),
                'columns' => $this->service->getTableColumns()
            ]
        ]);
    }
}
