<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Dashboard;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\News\Controller\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/", name="dashboard")
 */
class DashboardController extends AbstractController
{
    /**
     * @var NewsService
     */
    private NewsService $newsService;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * @param NewsService                   $newsService
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        NewsService                   $newsService,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->newsService = $newsService;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index", methods={"GET"})
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(): Response
    {
        $news = $this->newsService->getItems(new PaginationRequest(['size' => 4]));

        return $this->render('/app/dashboard/index.html.twig', [
            'news' => [
                'pagination' => $this->paginationSerializer->toArray($news),
                'items' => $news->getItems(),
                'columns' => $this->newsService->getTableColumns()
            ]
        ]);
    }
}
