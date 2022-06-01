<?php

declare(strict_types=1);

namespace App\Services\News\Controller;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\News\NewsFetcher;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class NewsService
{
    /**
     * @var NewsFetcher
     */
    private NewsFetcher $fetcher;

    /**
     * @param NewsFetcher $fetcher
     */
    public function __construct(NewsFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return PaginationInterface
     * @throws ExceptionInterface
     */
    public function getItems(PaginationRequestInterface $paginationRequest): PaginationInterface
    {
        return $this->fetcher->all($paginationRequest);
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return $this->fetcher->getTableColumns();
    }
}
