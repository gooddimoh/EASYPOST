<?php

declare(strict_types=1);


namespace App\ReadModels\User;

use App\Infrastructure\Enums\Model\StatusEnum;
use App\Infrastructure\PaginationRequest\Pagination\Filter;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\ORM\Pagination;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\Infrastructure\ReadModels\Sortable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class UserFetcher
 *
 * @package App\ReadModels\User
 */
class UserFetcher
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
            't.name_value AS name',
            't.company_company_id AS company_id',
            'c.name_value AS company',
            't.email_value as email',
            't.status_value as status',
            't.photo_value as photo',
            't.role_value as role',
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
                    DATE_TRUNC('day', u.date)::DATE AS day, 
                    COUNT(u.id) AS user_count
                FROM user_users AS u
                WHERE u.date::DATE >= :date_from
                AND u.date::DATE <= :date_to
                AND u.status_value = " . StatusEnum::ACTIVE . "
                GROUP BY day
                " . ")",
                'registration',
                'day_date = registration.day'
            );

        $stmtTotal = $this->connection->createQueryBuilder()
            ->select("json_build_object('registration', COALESCE(COUNT(t.id), 0)) AS items")
            ->from('user_users', 't')
            ->where('t.date::DATE >= :date_from')
            ->andWhere('t.date::DATE <= :date_to')
            ->andWhere('t.status_value = ' . StatusEnum::ACTIVE);

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
            'name',
            'email',
            'role',
            'company',
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
        $stmt = $this->connection->createQueryBuilder()
            ->select($select)
            ->from('user_users', 't')
            ->leftJoin('t', 'company_companies', 'c', 'c.id = t.company_company_id');
        $this->setFilters($stmt, $paginationRequest->getFilter());
        $this->setSort($stmt, $paginationRequest->getSort());

        return $stmt;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param Filter       $filters
     *
     * @throws ExceptionInterface
     */
    private function setFilters(QueryBuilder $queryBuilder, Filter $filters): void
    {
        $filter = new UserFilter();

        /**
         * @var $filter UserFilter
         */
        $filter = $this->denormalizer->denormalize(
            $filters->getFilters(),
            UserFilter::class,
            'array',
            [
                'object_to_populate' => $filter,
                'ignored_attributes' => [],
                'disable_type_enforcement' => true
            ]
        );

        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(':id', $filter->id);
        }

        if ($filter->exclude) {
            $queryBuilder->andWhere("t.id NOT IN (:exclude)");
            $queryBuilder->setParameter(':exclude', $filter->exclude, Connection::PARAM_STR_ARRAY);
        }

        if ($filter->name) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.name_value)', ':name'));
            $queryBuilder->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }
        if ($filter->email) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.email_value)', ':email_value'));
            $queryBuilder->setParameter(':email_value', '%' . mb_strtolower($filter->email) . '%');
        }

        if ($filter->status) {
            $queryBuilder->andWhere('t.status_value IN (:status)');
            $queryBuilder->setParameter(':status', $filter->status, Connection::PARAM_STR_ARRAY);
        } else {
            $queryBuilder->andWhere('t.status_value != :deleted');
            $queryBuilder->setParameter(':deleted', StatusEnum::BLOCK);
        }

        if ($filter->createDate) {
            $queryBuilder->andWhere("DATE(date) = :create_date");
            $queryBuilder->setParameter(':create_date', $filter->createDate);
        }

        if ($filter->companyId) {
            $queryBuilder->andWhere("t.company_company_id = :company");
            $queryBuilder->setParameter(':company', $filter->companyId);
        }

        if ($filter->company) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(c.name_value)', ':company'));
            $queryBuilder->setParameter(':company', '%' . mb_strtolower($filter->company) . '%');
        }

        if ($filter->role) {
            $queryBuilder->andWhere("role_value = :role");
            $queryBuilder->setParameter(':role', $filter->role);
        }

        if (!is_null($filter->count)) {
            $queryBuilder->andWhere("COALESCE(cc.count, 0) = :count");
            $queryBuilder->setParameter(':count', $filter->count);
        }
    }

    /**
     * @param string $email
     *
     * @return AuthView|null
     * @throws \Doctrine\DBAL\Exception
     */
    public function findForAuthByEmail(string $email): ?AuthView
    {
        $stmt = $this->queryFind()
            ->where('LOWER(t.email_value) = LOWER(:email) and t.status_value != :status')
            ->setParameter(':email', $email)
            ->setParameter(':status', StatusEnum::BLOCK)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, AuthView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
     * @param string $token
     *
     * @return AuthView|null
     * @throws \Doctrine\DBAL\Exception
     */
    public function existsByResetToken(string $token): ?AuthView
    {
        $stmt = $this->queryFind()
            ->where('reset_token_token = :token')
            ->setParameter(':token', $token)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, AuthView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
     * @param string $id
     *
     * @return DetailView|null
     * @throws \Doctrine\DBAL\Exception
     */
    public function findDetail(string $id): ?DetailView
    {
        $stmt = $this->queryFind()
            ->select(
                'id',
                'email_value as email',
                'date as create_date',
                'name',
                'status_value as status'
            )
            ->where('id = :id')
            ->setParameter(':id', $id)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, DetailView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    private function queryFind(): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select(
                't.id as id',
                't.email_value as email',
                't.photo_value as photo',
                't.password_hash_value as password_hash',
                'COALESCE(t.name_value, \'\') AS name',
                't.status_value as status',
                't.role_value as role',
                't.company_company_id as company',
                'cc.type_value as company_type',
                'cc.company_package_id as active_package',
                'cc.name_value as company_name',
                'cp.permissions_value as permissions',
            )
            ->from('user_users', 't')
            ->innerJoin('t', 'company_companies', 'cc', 'cc.id = t.company_company_id')
            ->leftJoin('t', 'company_packages', 'cp', 'cp.id = cc.company_package_id');
    }

    /**
     * @param array $filters
     *
     * @return UserFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): UserFilter
    {
        $filter = new UserFilter();

        $this->denormalizer->denormalize(
            $filters,
            UserFilter::class,
            'array',
            [
                'object_to_populate' => $filter,
                'ignored_attributes' => [],
                'disable_type_enforcement' => true
            ]
        );

        return $filter;
    }
}
