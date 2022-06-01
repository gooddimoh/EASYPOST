<?php

declare(strict_types=1);

namespace App\ReadModels\News;

use App\Infrastructure\Enums\Model\StatusEnum;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\ORM\Pagination;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\Infrastructure\ReadModels\Sortable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class NewsFetcher
{
    use Sortable;

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @var Pagination
     */
    private Pagination $paginator;

    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @param Connection            $connection
     * @param Pagination            $paginator
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(
        Connection            $connection,
        Pagination            $paginator,
        DenormalizerInterface $denormalizer
    ) {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->denormalizer = $denormalizer;

        $this->setDefaultSort('date', 'DESC');
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return PaginationInterface
     * @throws ExceptionInterface
     */
    public function all(PaginationRequestInterface $paginationRequest): PaginationInterface
    {
        $stmt = $this->getQuery(
            $paginationRequest,
            [
                't.id as id',
                't.title_value AS title',
                't.photo_value as photo',
                't.description_value AS description',
                't.link_value AS link',
                't.date AS date',
                't.status_value as status',
            ]
        );

        return $this->paginator->paginate($stmt, $paginationRequest);
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return [
            'title',
            'description',
            'date',
            'status',
        ];
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     * @param array                      $select
     *
     * @return QueryBuilder
     * @throws ExceptionInterface
     */
    public function getQuery(PaginationRequestInterface $paginationRequest, array $select): QueryBuilder
    {
        $stmt = $this->buildQuery($select);
        $filter = $this->denormalize($paginationRequest->getFilter()->getFilters());

        $this->setFilters($stmt, $filter);
        $this->setSort($stmt, $paginationRequest->getSort());

        return $stmt;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param NewsFilter   $filter
     */
    private function setFilters(QueryBuilder $queryBuilder, NewsFilter $filter): void
    {
        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(":id", $filter->id);
        }

        if ($filter->title) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.title_value)', ':title'));
            $queryBuilder->setParameter(':title', '%' . mb_strtolower($filter->title) . '%');
        }

        if ($filter->description) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.description_value)', ':description'));
            $queryBuilder->setParameter(':description', '%' . mb_strtolower($filter->description) . '%');
        }

        if ($filter->date) {
            $queryBuilder->andWhere("DATE(t.date) = :date");
            $queryBuilder->setParameter(':date', $filter->date);
        }

        if ($filter->status) {
            $queryBuilder->andWhere('t.status_value IN (:status)');
            $queryBuilder->setParameter(':status', $filter->status, Connection::PARAM_STR_ARRAY);
        } else {
            $queryBuilder->andWhere('t.status_value != :deleted');
            $queryBuilder->setParameter(':deleted', StatusEnum::BLOCK);
        }
    }

    /**
     * @param array $filters
     *
     * @return NewsFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): NewsFilter
    {
        $filter = new NewsFilter();

        $this->denormalizer->denormalize(
            $filters,
            NewsFilter::class,
            'array',
            [
                'object_to_populate' => $filter,
                'ignored_attributes' => [],
                'disable_type_enforcement' => true
            ]
        );

        return $filter;
    }

    /**
     * @param array $select
     *
     * @return QueryBuilder
     */
    private function buildQuery(array $select): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select($select)
            ->from('news_news', 't');
    }
}
