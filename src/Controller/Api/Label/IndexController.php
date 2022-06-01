<?php

declare(strict_types=1);

namespace App\Controller\Api\Label;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Model\Label\Entity\Label\Fields\Status;
use App\Services\Label\Controller\LabelService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/labels", name="label")
 *
 * Class IndexController
 *
 * @package App\Controller\Api\User
 */
class IndexController extends AbstractController
{
    /**
     * @var LabelService
     */
    private LabelService $service;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     *
     * @param LabelService                  $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        LabelService                  $service,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->service = $service;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        $labels = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->json([
            'status' => true,
            'message' => [
                'pagination' => $this->paginationSerializer->toArray($labels),
                'items' => $labels->getItems(),
                'columns' => $this->service->getTableColumns()
            ]
        ]);
    }

    /**
     * @Route("/draft", name=".draft", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function draft(Request $request): Response
    {
        $draftLabels = $this->service->getItems(
            new PaginationRequest(
                array_merge_recursive(
                    $request->query->all(),
                    ['filter' => ['status' => [Status::ITEMS['DRAFT']]]]
                )
            )
        );

        return $this->json([
            'status' => true,
            'message' => [
                'pagination' => $this->paginationSerializer->toArray($draftLabels),
                'items' => $draftLabels->getItems(),
                'columns' => $this->service->getDraftTableColumns()
            ]
        ]);
    }

    /**
     * @Route("/{id}", name=".show", methods={"GET"})
     *
     * @param string $id
     *
     * @return Response
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function show(string $id): Response
    {
        return $this->json([
            'status' => true,
            'message' => $this->service->getOne($id)
        ]);
    }
}
