<?php

declare(strict_types=1);

namespace App\ReadModels\Label;

use App\Infrastructure\Enums\Model\Carrier\NameEnum;
use App\Infrastructure\Enums\Model\StatusEnum;
use App\Infrastructure\Enums\Model\Transaction\StatusEnum as TransactionStatus;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\ORM\Pagination;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\Infrastructure\ReadModels\Sortable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class LabelFetcher
 *
 * @package App\ReadModels\Label
 */
class LabelFetcher
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

        $this->setDefaultSort('t.date', 'DESC');
    }

    /**
     * @param array $filter
     *
     * @return array
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function getOne(array $filter): array
    {
        $stmt = $this->buildQuery([
            't.id as id',
            't.date AS date',
            't.sender_name as sender_name',
            't.sender_type as sender_type',
            't.sender_code as sender_code',
            't.sender_phone as sender_phone',
            't.sender_email as sender_email',
            't.sender_street1 as sender_street1',
            't.sender_street2 as sender_street2',
            't.sender_city as sender_city',
            't.sender_state as sender_state',
            't.sender_country as sender_country',
            't.sender_zip as sender_zip',
            't.recipient_name as recipient_name',
            't.recipient_type as recipient_type',
            't.recipient_code as recipient_code',
            't.recipient_phone as recipient_phone',
            't.recipient_email as recipient_email',
            't.recipient_street1 as recipient_street1',
            't.recipient_street2 as recipient_street2',
            't.recipient_city as recipient_city',
            't.recipient_state as recipient_state',
            't.recipient_country as recipient_country',
            't.recipient_zip as recipient_zip',
            't.status_value as status',
            't.parcel_weight as weight',
            't.shipment_price as price',
            't.shipment_id as shipment_id',
            't.pickup_price as pickup_price',
            't.pickup_id as pickup_id',
            't.information_service as service',
            't.information_carrier as carrier',
            't.information_track as track',
            't.information_label_url as label_url',
        ]);

        $filter = $this->denormalize($filter);
        $this->setFilters($stmt, $filter);

        return $stmt->setMaxResults(1)->execute()->fetchAssociative() ?: [];
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
                '(
                    t.sender_street1 || \' \' ||  
                    COALESCE(t.sender_street2, \'\') || \' \' ||  
                    t.sender_city || \' \' || 
                    t.sender_state || \' \' || 
                    t.sender_country ||  \' \' || 
                    t.sender_zip
                ) as sender',
                '(
                    t.recipient_street1  ||  \' \' ||  
                    COALESCE(t.recipient_street2) ||  \' \' || 
                    t.recipient_city ||  \' \' || 
                    t.recipient_state ||  \' \' || 
                    t.recipient_country ||  \' \' || 
                    t.recipient_zip
                ) as recipient',
                't.status_value as status',
                't.parcel_weight as weight',
                't.shipment_price as price',
                't.pickup_price as pickup_price',
                't.pickup_id as pickup_id',
                't.information_service as service',
                't.information_carrier as carrier',
                't.information_track as track',
                't.information_label_url as label_url',
                't.options_value::json->>\'need_pickup\' AS need_pickup',
            ]
        );

        return $this->paginator->paginate($stmt, $paginationRequest);
    }

    /**
     * @param array                      $select
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function statisticCarriers(array $select, PaginationRequestInterface $paginationRequest): array
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
                    DATE_TRUNC('day', l.date)::DATE AS day, 
                    COUNT(l.id) AS usps_count
                FROM label_labels AS l
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.information_carrier = '" . NameEnum::USPS . "'
                AND l.status_value = " . StatusEnum::ACTIVE . "
                GROUP BY day
                " . ")",
                'usps',
                'day_date = usps.day'
            )
            ->leftJoin(
                'date_range',
                "LATERAL (" .
                "SELECT 
                    DATE_TRUNC('day', l.date)::DATE AS day, 
                    COUNT(l.id) AS fedex_count
                FROM label_labels AS l
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.information_carrier = '" . NameEnum::FEDEX . "'
                AND l.status_value = " . StatusEnum::ACTIVE . "
                GROUP BY day
                " . ")",
                'fedex',
                'day_date = fedex.day'
            )
            ->leftJoin(
                'date_range',
                "LATERAL (" .
                "SELECT 
                    DATE_TRUNC('day', l.date)::DATE AS day, 
                    COUNT(l.id) AS ups_count
                FROM label_labels AS l
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.information_carrier = '" . NameEnum::UPS . "'
                AND l.status_value = " . StatusEnum::ACTIVE . "
                GROUP BY day
                " . ")",
                'ups',
                'day_date = ups.day'
            );

        $stmtTotal = $this->connection->createQueryBuilder()
            ->select(
                sprintf(
                    "json_build_object('%s', COALESCE(usps_count, 0), '%s', COALESCE(ups_count, 0), '%s', COALESCE(fedex_count, 0)) as items",
                    NameEnum::USPS,
                    NameEnum::UPS,
                    NameEnum::FEDEX,
                )
            )
            ->from('label_labels', 't')
            ->leftJoin(
                't',
                "LATERAL (" .
                "SELECT 
                    COUNT(l.id) AS usps_count
                FROM label_labels AS l
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.information_carrier = '" . NameEnum::USPS . "'
                AND l.status_value = " . StatusEnum::ACTIVE . "
                " . ")",
                'usps',
                'TRUE'
            )
            ->leftJoin(
                't',
                "LATERAL (" .
                "SELECT 
                    COUNT(l.id) AS fedex_count
                FROM label_labels AS l
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.information_carrier = '" . NameEnum::FEDEX . "'
                AND l.status_value = " . StatusEnum::ACTIVE . "
                " . ")",
                'fedex',
                'TRUE'
            )
            ->leftJoin(
                't',
                "LATERAL (" .
                "SELECT 
                    COUNT(l.id) AS ups_count
                FROM label_labels AS l
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.information_carrier = '" . NameEnum::UPS . "'
                AND l.status_value = " . StatusEnum::ACTIVE . "
                " . ")",
                'ups',
                'TRUE'
            );

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
     * @param array                      $select
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function statisticLabels(array $select, PaginationRequestInterface $paginationRequest): array
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
                    DATE_TRUNC('day', l.date)::DATE AS day, 
                    COUNT(l.id) AS label_count
                FROM label_labels AS l
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = " . StatusEnum::ACTIVE . "
                GROUP BY day
                " . ")",
                'label',
                'day_date = label.day'
            );

        $stmtTotal = $this->connection->createQueryBuilder()
            ->select("json_build_object('label', COALESCE(COUNT(t.id), 0)) as items")
            ->from('label_labels', 't')
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
     * @param array                      $select
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function statisticIncome(array $select, PaginationRequestInterface $paginationRequest): array
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
                    DATE_TRUNC('day', t.date)::DATE AS day, 
                    SUM(t.balance_value) AS subscription_sum
                FROM company_company_transactions AS t
                WHERE t.date::DATE >= :date_from
                AND t.date::DATE <= :date_to
                AND t.type_options::jsonb ?? 'package'
                AND t.status_value = " . TransactionStatus::SUCCESS . "
                GROUP BY day
                " . ")",
                'subscription',
                'day_date = subscription.day'
            )
            ->leftJoin(
                'date_range',
                "LATERAL (" .
                "SELECT
                    DATE_TRUNC('day', l.date)::DATE AS day,
                    SUM(p.price_label) AS price_label_sum
                FROM label_labels AS l
                LEFT JOIN company_companies AS c ON l.company_company_id = c.id
                LEFT JOIN company_packages AS p ON c.company_package_id = p.id
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = " . StatusEnum::ACTIVE . "
                GROUP BY day
                " . ")",
                'price_label',
                'day_date = price_label.day'
            )
            ->leftJoin(
                'date_range',
                "LATERAL (" .
                "SELECT
                    DATE_TRUNC('day', l.date)::DATE AS day,
                    SUM(p.price_additional) AS price_additional_sum
                FROM label_labels AS l
                LEFT JOIN company_companies AS c ON l.company_company_id = c.id
                LEFT JOIN company_packages AS p ON c.company_package_id = p.id
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = " . StatusEnum::ACTIVE . "
                GROUP BY day
                " . ")",
                'price_additional',
                'day_date = price_additional.day'
            );

        $stmtTotal = $this->connection->createQueryBuilder()
            ->select(
                "json_build_object('subscription', COALESCE(subscription_sum, 0), 'label', COALESCE(price_label_sum, 0), 'additional', COALESCE(price_additional_sum, 0)) as items"
            )
            ->from('label_labels', 'l')
            ->leftJoin(
                'l',
                "LATERAL (" .
                "SELECT 
                    SUM(t.balance_value) AS subscription_sum
                FROM company_company_transactions AS t
                WHERE t.date::DATE >= :date_from
                AND t.date::DATE <= :date_to
                AND t.type_options::jsonb ?? 'package'
                AND t.status_value = " . TransactionStatus::SUCCESS . "
                " . ")",
                'subscription',
                'TRUE'
            )
            ->leftJoin(
                'l',
                "LATERAL (" .
                "SELECT 
                    SUM(p.price_label) AS price_label_sum
                FROM label_labels AS ll
                LEFT JOIN company_companies AS c ON ll.company_company_id = c.id
                LEFT JOIN company_packages AS p ON c.company_package_id = p.id
                WHERE ll.date::DATE >= :date_from
                AND ll.date::DATE <= :date_to
                AND ll.status_value = " . StatusEnum::ACTIVE . "
                " . ")",
                'price_label',
                'TRUE'
            )
            ->leftJoin(
                'l',
                "LATERAL (" .
                "SELECT 
                    SUM(p.price_additional) AS price_additional_sum
                FROM label_labels AS ll
                LEFT JOIN company_companies AS c ON ll.company_company_id = c.id
                LEFT JOIN company_packages AS p ON c.company_package_id = p.id
                WHERE ll.date::DATE >= :date_from
                AND ll.date::DATE <= :date_to
                AND ll.status_value = " . StatusEnum::ACTIVE . "
                " . ")",
                'price_additional',
                'TRUE'
            );

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
     * @param array                      $select
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function statisticLabelsTable(array $select, PaginationRequestInterface $paginationRequest): array
    {
        $filter = $this->denormalize($paginationRequest->getFilter()->getFilters());

        $stmtByUser = $this->connection->createQueryBuilder()
            ->select($select)
            ->from('user_users', 'u')
            ->innerJoin('u', 'label_labels', 't', 'u.id = t.user_user_id')
            ->leftJoin(
                't',
                "LATERAL (" .
                "SELECT 
                    SUM(l.shipment_price) + SUM(COALESCE(l.pickup_price, 0)) AS usps_sum
                FROM label_labels AS l
                WHERE u.id = l.user_user_id
                AND l.information_carrier = '" . NameEnum::USPS . "'
                AND l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                " . ")",
                'usps',
                'TRUE'
            )
            ->leftJoin(
                't',
                "LATERAL (" .
                "SELECT 
                    SUM(l.shipment_price) + SUM(COALESCE(l.pickup_price, 0)) AS fedex_sum
                FROM label_labels AS l
                WHERE u.id = l.user_user_id
                AND l.information_carrier = '" . NameEnum::FEDEX . "'
                AND l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                " . ")",
                'fedex',
                'TRUE'
            )
            ->leftJoin(
                't',
                "LATERAL (" .
                "SELECT 
                    SUM(l.shipment_price) + SUM(COALESCE(l.pickup_price, 0)) AS ups_sum
                FROM label_labels AS l
                WHERE u.id = l.user_user_id
                AND l.information_carrier = '" . NameEnum::UPS . "'
                AND l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                " . ")",
                'ups',
                'TRUE'
            )
            ->leftJoin(
                't',
                "LATERAL (" .
                "SELECT 
                    SUM(p.price_label) + SUM(p.price_additional) AS profit
                FROM label_labels AS l
                    INNER JOIN company_companies c ON t.company_company_id = c.id
                    INNER JOIN company_packages p ON c.company_package_id = p.id
                WHERE u.id = l.user_user_id
                AND l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                " . ")",
                'profit',
                'TRUE'
            );

        $this->setFilters($stmtByUser, $filter);

        $sort = $paginationRequest->getSort();

        if (!$sort->isEmpty()) {
            $column = $sort->getColumn();
            $direction = $sort->getDirection();
            $stmtByUser->addOrderBy($column, $direction);
        }

        $stmtTotal = $this->connection->createQueryBuilder()
            ->select(
                "JSON_BUILD_OBJECT('usps', SUM(COALESCE(usps.usps_sum, 0)), 'fedex',
                         SUM(COALESCE(fedex.fedex_sum, 0)),
                         'ups', SUM(COALESCE(ups.ups_sum, 0)), 'total_spent',
                         SUM(COALESCE(usps.usps_sum, 0) + COALESCE(fedex.fedex_sum, 0) +
                             COALESCE(ups.ups_sum, 0)), 'total_profit',
                         SUM(COALESCE(profit.profit, 0))) AS items"
            )
            ->from('user_users', 'u')
            ->leftJoin(
                'u',
                "LATERAL (" .
                "SELECT 
                    SUM(l.shipment_price) + SUM(COALESCE(l.pickup_price, 0)) AS usps_sum
                FROM label_labels AS l
                WHERE l.information_carrier = '" . NameEnum::USPS . "'
                AND u.id = l.user_user_id
                AND l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                " . ")",
                'usps',
                'TRUE'
            )
            ->leftJoin(
                'u',
                "LATERAL (" .
                "SELECT 
                    SUM(l.shipment_price) + SUM(COALESCE(l.pickup_price, 0)) AS fedex_sum
                FROM label_labels AS l
                WHERE l.information_carrier = '" . NameEnum::FEDEX . "'
                AND u.id = l.user_user_id
                AND l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                " . ")",
                'fedex',
                'TRUE'
            )
            ->leftJoin(
                'u',
                "LATERAL (" .
                "SELECT 
                    SUM(l.shipment_price) + SUM(COALESCE(l.pickup_price, 0)) AS ups_sum
                FROM label_labels AS l
                WHERE l.information_carrier = '" . NameEnum::UPS . "'
                AND u.id = l.user_user_id
                AND l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                " . ")",
                'ups',
                'TRUE'
            )
            ->leftJoin(
                'u',
                "LATERAL (" .
                "SELECT 
                    SUM(p.price_label) + SUM(p.price_additional) AS profit
                FROM label_labels AS l
                    INNER JOIN company_companies c ON l.company_company_id = c.id
                    INNER JOIN company_packages p ON c.company_package_id = p.id
                WHERE l.date::DATE >= :date_from
                AND l.date::DATE <= :date_to
                AND l.status_value = :active
                AND u.id = l.user_user_id
                " . ")",
                'profit',
                'TRUE'
            );

        $stmtTotal->setParameter(":date_from", $filter->dateFrom);
        $stmtTotal->setParameter(":date_to", $filter->dateTo);
        $stmtTotal->setParameter(':active', StatusEnum::ACTIVE);

        if ($filter->name) {
            $stmtTotal->andWhere(
                $stmtTotal->expr()->like(
                    'LOWER(u.name_value)',
                    ':name'
                )
            );
            $stmtTotal->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        return [
            'total' => $stmtTotal->execute()->fetchOne() ?: '{}',
            'pagination_data' => $this->paginator->paginate($stmtByUser, $paginationRequest),
            'columns' => [
                'name',
                'usps_spent',
                'fedex_spent',
                'ups_spent',
                'total_spent',
                'total_profit',
            ]
        ];
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return [
            'date',
            'sender',
            'recipient',
            'weight',
            'service',
            'carrier',
            'track',
            'price',
            'pickup_price',
        ];
    }

    /**
     * @return array
     */
    public function getDraftTableColumns(): array
    {
        return [
            'date',
            'sender',
            'recipient',
            'weight',
        ];
    }

    /**
     * @param string|null $label
     * @param string|null $id
     *
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
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
     * @param LabelFilter  $filter
     */
    private function setFilters(QueryBuilder $queryBuilder, LabelFilter $filter): void
    {
        if ($filter->id) {
            $queryBuilder->andWhere("t.id = :id");
            $queryBuilder->setParameter(":id", $filter->id);
        }

        if ($filter->weight) {
            $queryBuilder->andWhere('t.parcel_weight = :weight');
            $queryBuilder->setParameter(':weight', $filter->weight);
        }

        if ($filter->track) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.information_track)', ':track'));
            $queryBuilder->setParameter(':track', mb_strtolower($filter->track) . '%');
        }

        if ($filter->service) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.information_service)', ':service'));
            $queryBuilder->setParameter(':service', '%' . mb_strtolower($filter->service) . '%');
        }

        if ($filter->carrier) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('LOWER(t.information_carrier)', ':carrier'));
            $queryBuilder->setParameter(':carrier', '%' . mb_strtolower($filter->carrier) . '%');
        }

        if ($filter->price) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('t.shipment_price::text', ':price'));
            $queryBuilder->setParameter(':price', mb_strtolower($filter->price) . '%');
        }

        if ($filter->pickupPrice) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('t.pickup_price::text', ':pickup'));
            $queryBuilder->setParameter(':pickup', mb_strtolower($filter->pickupPrice) . '%');
        }

        if ($filter->date) {
            $queryBuilder->andWhere("DATE(date) = :date");
            $queryBuilder->setParameter(':date', $filter->date);
        }

        if ($filter->sender) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    'LOWER(
                    t.sender_street1 || \' \' ||
                    t.sender_street2 || \' \' || 
                    t.sender_city || \' \' ||
                    t.sender_state || \' \' ||
                    t.sender_country || \' \' ||
                    t.sender_zip
                )',
                    ':sender'
                )
            );

            $queryBuilder->setParameter(':sender', '%' . mb_strtolower($filter->sender) . '%');
        }

        if ($filter->recipient) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    'LOWER(
                    t.recipient_street1 || \' \' || 
                    t.recipient_street2 || \' \' ||
                    t.recipient_city || \' \' ||
                    t.recipient_state || \' \' ||
                    t.recipient_country ||  \' \' ||
                    t.recipient_zip
                )',
                    ':recipient'
                )
            );

            $queryBuilder->setParameter(':recipient', '%' . mb_strtolower($filter->recipient) . '%');
        }

        if ($filter->status) {
            $queryBuilder->andWhere('t.status_value IN (:status)');
            $queryBuilder->setParameter(':status', $filter->status, Connection::PARAM_STR_ARRAY);
        } else {
            $queryBuilder->andWhere('t.status_value = :active');
            $queryBuilder->setParameter(':active', StatusEnum::ACTIVE);
        }

        if ($filter->companyId) {
            $queryBuilder->andWhere("t.company_company_id = :companyId");
            $queryBuilder->setParameter(":companyId", $filter->companyId);
        }

        if ($filter->userId) {
            $queryBuilder->andWhere("t.user_user_id = :userId");
            $queryBuilder->setParameter(":userId", $filter->userId);
        }

        if ($filter->dateFrom) {
            $queryBuilder->andWhere("t.date::DATE >= :date_from");
            $queryBuilder->setParameter(":date_from", $filter->dateFrom);
        }

        if ($filter->dateTo) {
            $queryBuilder->andWhere("t.date::DATE <= :date_to");
            $queryBuilder->setParameter(":date_to", $filter->dateTo);
        }

        if ($filter->name) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    'LOWER(u.name_value)',
                    ':name'
                )
            );
            $queryBuilder->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }
    }

    /**
     * @param array $filters
     *
     * @return LabelFilter
     * @throws ExceptionInterface
     */
    private function denormalize(array $filters): LabelFilter
    {
        $filter = new LabelFilter();

        $this->denormalizer->denormalize(
            $filters,
            LabelFilter::class,
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
            ->from('label_labels', 't');
    }
}
