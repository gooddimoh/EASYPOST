<?php

declare(strict_types=1);

namespace App\ReadModels\Carrier;

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
 * Class CarrierFetcher
 *
 * @package App\ReadModels\Carrier
 */
class CarrierFetcher
{
    use Sortable;

    const LIMIT = 3;

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @var Pagination
     */
    private Pagination $paginator;

    /**
     * CarrierFetcher constructor.
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
                'DISTINCT ON (t.type_value) t.type_value as type',
                't.id as id',
                't.name_value AS name',
                't.custom_value AS custom',
                't.editable_value AS editable',
                't.description_value AS description',
                't.carrier_account_value AS carrier_account',
                'CASE
                    WHEN t.custom_value IS TRUE THEN t.credentials_value
                    ELSE \'{}\' END   AS credentials',
                't.date AS date',
                't.status_value as status',
            ]
        );

        return $this->paginator->paginate($stmt, $paginationRequest);
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
                'DISTINCT ON (t.type_value) t.type_value as label',
                't.id as value',
            ]
        );

        $filter = $this->denormalize(
            [
                'id' => $id,
                'name' => $label,
            ] + $filter
        );

        $this->setFilters($stmt, $filter);
        $stmt->addOrderBy('t.type_value');
        $stmt->addOrderBy('t.custom_value', 'DESC');

        return $stmt->setMaxResults(self::LIMIT)->execute()->fetchAllAssociative();
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
        $stmt->addOrderBy('t.type_value');
        $stmt->addOrderBy('t.custom_value', 'DESC');

        return $stmt;
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return [
            'type',
            'name',
            'description',
            'carrier_account',
            'status',
        ];
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
            ->from('label_carriers', 't');
    }

    /**
     * @param array $filters
     *
     * @return CarrierFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): CarrierFilter
    {
        $filter = new CarrierFilter();

        $this->denormalizer->denormalize(
            $filters,
            CarrierFilter::class,
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
     * @param QueryBuilder  $queryBuilder
     * @param CarrierFilter $filter
     */
    private function setFilters(QueryBuilder $queryBuilder, CarrierFilter $filter): void
    {
        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(":id", $filter->id);
        }

        // Если необходимо получить carrier-ов в рамках одной компании, мы находим сначала пользовательские,
        // а далее дополняем их дефолтными, если это необходимо.
        if ($filter->companyId) {
            $queryBuilder->andWhere("t.company_company_id = :companyId OR t.custom_value = :custom");
            $queryBuilder->setParameter(":companyId", $filter->companyId);
            $queryBuilder->setParameter('custom', false, 'boolean');
            $queryBuilder->innerJoin(
                't',
                'label_carriers',
                't2',
                't.type_value <> t2.type_value'
            );
        }

        if (is_bool($filter->custom)) {
            $queryBuilder->andWhere('t.custom_value = :custom');
            $queryBuilder->setParameter(':custom', $filter->custom, 'boolean');
        }

        if ($filter->types) {
            $queryBuilder->andWhere('t.type_value IN (:types)');
            $queryBuilder->setParameter(':types', $filter->types, Connection::PARAM_STR_ARRAY);
        }

        if ($filter->status) {
            $queryBuilder->andWhere('t.status_value = :status');
            $queryBuilder->setParameter(':status', $filter->status);
        } else {
            $queryBuilder->andWhere('t.status_value != :deleted');
            $queryBuilder->setParameter(':deleted', StatusEnum::BLOCK);
        }
    }
}
