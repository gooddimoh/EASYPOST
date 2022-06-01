<?php

declare(strict_types=1);


namespace App\ReadModels\AddressBook;

use App\Infrastructure\Enums\Model\StatusEnum;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\ORM\Pagination;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\Infrastructure\ReadModels\Sortable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class AddressBookFetcher
 * @package App\ReadModels\AddressBook
 */
class AddressBookFetcher
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
     * @return PaginationInterface
     * @throws ExceptionInterface
     */
    public function all(PaginationRequestInterface $paginationRequest): PaginationInterface
    {
        $stmt = $this->getQuery($paginationRequest, [
            't.id as id',
            't.name_value AS name',
            't.date AS date',
            't.type_address AS type_address',
            't.contact_code AS code',
            't.contact_phone AS phone',
            't.contact_email AS email',
            't.address_street1 AS street1',
            't.address_street2 AS street2',
            't.address_city AS city',
            't.address_state AS state',
            't.address_country AS country',
            't.address_zip AS zip',
            't.description_value AS description',
            't.status_value as status',
        ]);

        return $this->paginator->paginate($stmt, $paginationRequest);
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return [
            'name',
            'date',
            'phone',
            'email',
            'street1',
            'street2',
            'city',
            'state',
            'country',
            'zip',
            'description',
            'status',
        ];
    }

    /**
     * @param string|null $label
     * @param string|null $id
     * @param array $filter
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getList(?string $label = null, ?string $id = null, array $filter = []): array
    {
        $stmt = $this->buildQuery([
            't.id as value',
            't.name_value AS label',
        ]);

        $filter = $this->denormalize([
                'id' => $id,
                'name' => $label,
            ] + $filter);

        $this->setFilters($stmt, $filter);

        return $stmt->setMaxResults(50)->execute()->fetchAllAssociative();
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     * @param array $select
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
     * @param AddressBookFilter $filter
     */
    private function setFilters(QueryBuilder $queryBuilder, AddressBookFilter $filter): void
    {
        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(":id", $filter->id);
        }

        if ($filter->name) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.name_value)', ':name'));
            $queryBuilder->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->type) {
            $queryBuilder->andWhere('t.type_record = :type');
            $queryBuilder->setParameter(':type', $filter->type);
        }

        if ($filter->date) {
            $queryBuilder->andWhere("DATE(date) = :date");
            $queryBuilder->setParameter(':date', $filter->date);
        }

        if ($filter->phone) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.contact_code || t.contact_phone)', ':phone'));
            $queryBuilder->setParameter(':phone', '%' . mb_strtolower($filter->phone) . '%');
        }

        if ($filter->email) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.contact_email)', ':email'));
            $queryBuilder->setParameter(':email', '%' . mb_strtolower($filter->email) . '%');
        }

        if ($filter->street1) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.address_street1)', ':street1'));
            $queryBuilder->setParameter(':street1', '%' . mb_strtolower($filter->street1) . '%');
        }

        if ($filter->street2) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.address_street2)', ':street2'));
            $queryBuilder->setParameter(':street2', '%' . mb_strtolower($filter->street2) . '%');
        }

        if ($filter->city) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.address_city)', ':city'));
            $queryBuilder->setParameter(':city', '%' . mb_strtolower($filter->city) . '%');
        }

        if ($filter->state) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.address_state)', ':state'));
            $queryBuilder->setParameter(':state', '%' . mb_strtolower($filter->state) . '%');
        }

        if ($filter->country) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.address_country)', ':country'));
            $queryBuilder->setParameter(':country', mb_strtolower($filter->country));
        }

        if ($filter->zip) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.address_zip)', ':zip'));
            $queryBuilder->setParameter(':zip', '%' . mb_strtolower($filter->zip) . '%');
        }

        if ($filter->description) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.description_value)', ':description'));
            $queryBuilder->setParameter(':description', '%' . mb_strtolower($filter->description) . '%');
        }

        if ($filter->status) {
            $queryBuilder->andWhere('t.status_value IN (:status)');
            $queryBuilder->setParameter(':status', $filter->status, Connection::PARAM_STR_ARRAY);
        } else {
            $queryBuilder->andWhere('t.status_value != :deleted');
            $queryBuilder->setParameter(':deleted', StatusEnum::BLOCK);
        }

        if ($filter->companyId) {
            $queryBuilder->andWhere("t.company_company_id = :companyId");
            $queryBuilder->setParameter(":companyId", $filter->companyId);
        }

        if ($filter->userId) {
            $queryBuilder->andWhere("t.user_user_id = :userId");
            $queryBuilder->setParameter(":userId", $filter->userId);
        }
    }

    /**
     * @param array $filters
     * @return AddressBookFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): AddressBookFilter
    {
        $filter = new AddressBookFilter();

        $this->denormalizer->denormalize(
            $filters,
            AddressBookFilter::class,
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
     * @return QueryBuilder
     */
    private function buildQuery(array $select): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select($select)
            ->from('label_address_books', 't');
    }
}
