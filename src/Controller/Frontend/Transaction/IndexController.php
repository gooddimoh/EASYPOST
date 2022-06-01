<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Transaction;

use App\Export\Transaction\TransactionExport;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Model\Company\Entity\Transaction\Transaction;
use App\Services\Export\XlsxService;
use App\Services\Transaction\Controller\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/transactions", name="transaction")
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
        TransactionService            $service,
        PaginationSerializerInterface $paginationSerializer
    )
    {
        $this->service = $service;
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

        return $this->render('/app/transaction/index.html.twig', [
            'pagination' => $this->paginationSerializer->toArray($companies),
            'items' => $companies->getItems(),
            'columns' => $this->service->getTableColumns()
        ]);
    }

    /**
     * @Route("/create", name=".create")
     *
     * @return Response
     */
    public function create(): Response
    {
        return $this->render('app/transaction/create.html.twig');
    }

    /**
     * @Route("/export", name=".export", methods={"GET"})
     *
     * @param Request $request
     * @param XlsxService $service
     * @param TransactionExport $companyExport
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request, XlsxService $service, TransactionExport $companyExport)
    {
        $filter = [];

        if (!$this->isGranted('ROLE_ADMIN')) {
            $filter['company_id'] = $this->getUser()->getCompany();
        }

        $companyExport->setFilters(new PaginationRequest(array_merge_recursive(
            $request->query->all(),
            ['filter' => $filter]
        )));

        $file = $service->generate($companyExport);

        return $this->file($file->getTempFile(), $file->getFileName(), ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
