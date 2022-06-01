<?php

declare(strict_types=1);

namespace App\ReadModels\Package;

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
 * Class PackageFetcher
 *
 * @package App\ReadModels\Package
 */
class PackageFetcher
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
     * PackageFetcher constructor.
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
        $stmt = $this->getQuery(
            $paginationRequest,
            [
                't.id as id',
                't.date AS date',
                't.price_month as price_month',
                't.price_label as price_label',
                't.name_value as name',
                't.status_value as status',
                't.permissions_value as permissions',
                't.available_company_value as available_company',
            ]
        );

        return $this->paginator->paginate($stmt, $paginationRequest);
    }

    /**
     * @param array $filter
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function getOne(array $filter): array
    {
        $stmt = $this->buildQuery([
            't.id as id',
            't.date AS date',
            't.price_month as price_month',
            't.price_label as price_label',
            't.name_value as name',
            't.status_value as status',
            't.permissions_value as permissions',
            't.available_company_value as available_company',
        ]);

        $filter = $this->denormalize($filter);
        $this->setFilters($stmt, $filter);

        return $stmt->setMaxResults(1)->execute()->fetchAssociative();
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return [
            'name',
            'price_month',
            'price_label',
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
            ] + $filter
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
    public function getLabelPrice(string $companyId): int
    {
        $stmt = $this->buildQuery(['t.price_label + t.price_additional as price_label']);
        $stmt->innerJoin('t', 'company_companies', 'cc', 'cc.company_package_id = t.id');

        $stmt->andWhere("cc.id = :company");
        $stmt->setParameter(":company", $companyId);

        $priceLabel = $stmt->execute()->fetchOne();

        if ($priceLabel === false) {
            throw new \DomainException('Price label for current company not found.');
        }

        return (int) $priceLabel;
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
     * @param QueryBuilder  $queryBuilder
     * @param PackageFilter $filter
     */
    private function setFilters(QueryBuilder $queryBuilder, PackageFilter $filter): void
    {
        if ($filter->status) {
            $queryBuilder->andWhere('t.status_value IN (:status)');
            $queryBuilder->setParameter(':status', $filter->status, Connection::PARAM_STR_ARRAY);
        } else {
            $queryBuilder->andWhere('t.status_value != :deleted');
            $queryBuilder->setParameter(':deleted', StatusEnum::BLOCK);
        }

        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(":id", $filter->id);
        }

        if ($filter->availableCompany) {
            if ($filter->availableCompany !== '-') {
                $queryBuilder->andWhere(
                    "(t.available_company_value = :available_company OR t.available_company_value IS NULL)"
                );
                $queryBuilder->setParameter(":available_company", $filter->availableCompany);
            }
        } else {
            $queryBuilder->andWhere("t.available_company_value IS NULL");
        }

        if ($filter->name) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.name_value)', ':description'));
            $queryBuilder->setParameter(':description', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->date) {
            $queryBuilder->andWhere("DATE(t.date) = :date");
            $queryBuilder->setParameter(':date', $filter->date);
        }

        if ($filter->priceMonth) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("t.price_month::text", ":price_month"));
            $queryBuilder->setParameter(':price_month', '%' . mb_strtolower($filter->priceMonth) . '%');
        }

        if ($filter->priceLabel) {
            $queryBuilder->andWhere($queryBuilder->expr()->like("t.price_label::text", ":price_label"));
            $queryBuilder->setParameter(':price_label', '%' . mb_strtolower($filter->priceLabel) . '%');
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
     * @return PackageFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): PackageFilter
    {
        $filter = new PackageFilter();

        $this->denormalizer->denormalize(
            $filters,
            PackageFilter::class,
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
            ->from('company_packages', 't');
    }
}
