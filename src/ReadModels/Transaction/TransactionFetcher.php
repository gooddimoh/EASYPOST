<?php

declare(strict_types=1);

namespace App\ReadModels\Transaction;

use App\Infrastructure\Enums\Model\Transaction\StatusEnum;
use App\Infrastructure\Enums\Model\Transaction\TypeEnum;
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
 * Class TransactionFetcher
 *
 * @package App\ReadModels\Transaction
 */
class TransactionFetcher
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
        $stmt = $this->getQuery($paginationRequest, [
            't.id as id',
            't.date AS date',
            't.type_value AS type',
            't.balance_value as balance',
            't.user_user_id AS user_id',
            't.type_options::json->>\'carrier\' AS carrier',
            't.description_value as description',
            't.status_value as status',
            'u.name_value AS user_name',
        ]);

        return $this->paginator->paginate($stmt, $paginationRequest);
    }

    /**
     * @param array                      $select
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function statistic(array $select, PaginationRequestInterface $paginationRequest): array
    {
        $filter = $this->denormalize($paginationRequest->getFilter()->getFilters());

        $sub_query = $this->connection->createQueryBuilder()
            ->select('day_date::DATE')
            ->from("GENERATE_SERIES(:date_from, :date_to, INTERVAL '1 day')", 'day_date');

        $stmt = $this->connection->createQueryBuilder()
            ->select($select)
            ->from('(' . $sub_query->getSQL() . ')', 'date_range')
            ->leftJoin(
                'date_range',
                "LATERAL (" .
                "SELECT 
                    DATE_TRUNC('day', c.date)::DATE AS day, 
                    SUM(c.balance_value) as credit_balance
                FROM company_company_transactions AS c
                WHERE c.date::DATE >= :date_from
                AND c.date::DATE <= :date_to
                AND c.type_value = " . TypeEnum::CREDIT . "
                AND c.status_value = " . StatusEnum::SUCCESS . "
                GROUP BY day
                " . ")",
                'credit',
                'day_date = credit.day'
            );

        $stmtTotal = $this->connection->createQueryBuilder()
            ->select("json_build_object('credit', COALESCE(SUM(c.balance_value), 0)) AS items")
            ->from('company_company_transactions', 'c')
            ->where('c.date::DATE >= :date_from')
            ->andWhere('c.date::DATE <= :date_to')
            ->andWhere('c.type_value = ' . TypeEnum::CREDIT)
            ->andWhere('c.status_value = ' . StatusEnum::SUCCESS);

        $stmt->setParameter(":date_from", $filter->dateFrom);
        $stmt->setParameter(":date_to", $filter->dateTo);
        $stmtTotal->setParameter(":date_from", $filter->dateFrom);
        $stmtTotal->setParameter(":date_to", $filter->dateTo);

        return [
            'total' => $stmtTotal->execute()->fetchOne() ?: '{}',
            'graph' => $stmt->execute()->fetchAllAssociative()
        ];
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return [
            'date',
            'type',
            'balance',
            'user_name',
            'description',
            'carrier',
            'status',
        ];
    }

    /**
     * @param string|null $label
     * @param string|null $id
     * @param array       $filter
     *
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getList(?string $label = null, ?string $id = null, array $filter = []): array
    {
        $stmt = $this->buildQuery([
            't.id as value',
            't.name_value AS label',
        ]);

        $filter = $this->denormalize(
            [
                'id' => $id,
                'name' => $label,
            ] + $filter
        );

        $this->setFilters($stmt, $filter);

        return $stmt->setMaxResults(50)->execute()->fetchAllAssociative();
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
     * @param QueryBuilder      $queryBuilder
     * @param TransactionFilter $filter
     */
    private function setFilters(QueryBuilder $queryBuilder, TransactionFilter $filter): void
    {
        if ($filter->status) {
            $queryBuilder->andWhere('t.status_value IN (:status)');
            $queryBuilder->setParameter(':status', $filter->status, Connection::PARAM_STR_ARRAY);
        } else {
            $queryBuilder->andWhere('t.status_value != :failed');
            $queryBuilder->setParameter(':failed', StatusEnum::FAIL);
        }

        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(":id", $filter->id);
        }

        if ($filter->description) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.description_value)', ':description'));
            $queryBuilder->setParameter(':description', '%' . mb_strtolower($filter->description) . '%');
        }

        if ($filter->carrier) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    'LOWER(t.type_options::json->>\'carrier\')',
                    ':carrier'
                )
            );
            $queryBuilder->setParameter(':carrier', '%' . mb_strtolower($filter->carrier) . '%');
        }

        if ($filter->userName) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    'LOWER(u.name_value)',
                    ':userName'
                )
            );
            $queryBuilder->setParameter(':userName', '%' . mb_strtolower($filter->userName) . '%');
        }

        if ($filter->date) {
            $queryBuilder->andWhere("DATE(t.date) = :date");
            $queryBuilder->setParameter(':date', $filter->date);
        }

        if ($filter->type) {
            $queryBuilder->andWhere("t.type_value = :type");
            $queryBuilder->setParameter(':type', $filter->type);
        }

        if ($filter->balance) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("t.balance_value::text", ":balance"));
            $queryBuilder->setParameter(':balance', '%' . mb_strtolower($filter->balance) . '%');
        }

        if ($filter->companyId) {
            $queryBuilder->andWhere("t.company_company_id = :companyId");
            $queryBuilder->setParameter(':companyId', $filter->companyId);
        }

        if ($filter->userId) {
            $queryBuilder->andWhere("t.user_user_id = :userId");
            $queryBuilder->setParameter(':userId', $filter->userId);
        }
    }

    /**
     * @param array $filters
     *
     * @return TransactionFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): TransactionFilter
    {
        $filter = new TransactionFilter();

        $this->denormalizer->denormalize(
            $filters,
            TransactionFilter::class,
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
            ->from('company_company_transactions', 't')
            ->innerJoin('t', 'user_users', 'u', 'u.id = t.user_user_id');
    }
}
