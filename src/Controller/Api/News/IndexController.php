<?php

declare(strict_types=1);

namespace App\Controller\Api\News;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\News\Controller\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/news", name="news")
 */
class IndexController extends AbstractController
{
    /**
     * @var NewsService
     */
    private NewsService $service;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * @param NewsService                   $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        NewsService                   $service,
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
        $news = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'pagination' => $this->paginationSerializer->toArray($news),
                    'items' => $news->getItems(),
                    'columns' => $this->service->getTableColumns()
                ]
            ]
        );
    }
}
