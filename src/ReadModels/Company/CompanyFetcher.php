<?php

declare(strict_types=1);

namespace App\ReadModels\Company;

use App\Infrastructure\Enums\Model\StatusEnum;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\ORM\Pagination;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\Infrastructure\ReadModels\Sortable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class CompanyFetcher
 *
 * @package App\ReadModels\Company
 */
class CompanyFetcher
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
     * CompanyFetcher constructor.
     *
     * @param Connection $connection
     * @param Pagination $paginator
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(
        Connection $connection,
        Pagination $paginator,
        DenormalizerInterface $denormalizer
    )
    {
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
                't.name_value AS name',
                't.type_value AS type',
                't.date AS date',
                't.photo_value as photo',
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
            'name',
            'type',
            'date',
            'status',
        ];
    }

    /**
     * @param string|null $label
     * @param string|null $id
     *
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getList(?string $label = null, ?string $id = null): array
    {
        $stmt = $this->buildQuery(
            [
                't.id as value',
                't.name_value AS label',
            ]
        );

        $filter = $this->denormalize(
            [
                'id' => $id,
                'name' => $label,
            ]
        );

        $this->setFilters($stmt, $filter);

        return $stmt->setMaxResults(50)->execute()->fetchAllAssociative();
    }

    /**
     * @param string $companyId
     *
     * @return int
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getBalance(string $companyId): int
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select('t.total as total')
            ->from('company_company_balances', 't');

        $stmt->andWhere("t.company_company_id = :company");
        $stmt->setParameter(":company", $companyId);

        $balance = $stmt->execute()->fetchOne();

        if ($balance === false) {
            throw new \DomainException('Company not found.');
        }

        return (int)$balance;
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     * @param array $select
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
     * @param CompanyFilter $filter
     */
    private function setFilters(QueryBuilder $queryBuilder, CompanyFilter $filter): void
    {
        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(":id", $filter->id);
        }

        if ($filter->type) {
            $queryBuilder->andWhere("t.type_value = :type");
            $queryBuilder->setParameter(":type", $filter->type);
        }

        if ($filter->name) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.name_value)', ':name'));
            $queryBuilder->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
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
     * @return CompanyFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): CompanyFilter
    {
        $filter = new CompanyFilter();

        $this->denormalizer->denormalize(
            $filters,
            CompanyFilter::class,
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
            ->from('company_companies', 't');
    }
}
