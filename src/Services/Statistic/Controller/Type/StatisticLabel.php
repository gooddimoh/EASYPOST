<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Type;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\ReadModels\Label\LabelFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class StatisticLabel extends BaseType
{
    /**
     * @var LabelFetcher
     */
    private LabelFetcher $labelFetcher;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * @param LabelFetcher                  $labelFetcher
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        LabelFetcher                  $labelFetcher,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->labelFetcher = $labelFetcher;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function getData(PaginationRequestInterface $paginationRequest): array
    {
        $statisticLabelsTable = $this->labelFetcher->statisticLabelsTable(
            [
                'DISTINCT u.id AS id',
                'u.name_value AS name',
                'COALESCE(usps.usps_sum, 0) AS usps_spent',
                'COALESCE(fedex.fedex_sum, 0) AS fedex_spent',
                'COALESCE(ups.ups_sum, 0) AS ups_spent',
                'COALESCE(usps.usps_sum, 0) + COALESCE(fedex.fedex_sum, 0) + COALESCE(ups.ups_sum, 0) AS total_spent',
                'COALESCE(profit.profit, 0) AS total_profit',
            ],
            $paginationRequest
        );

        return [
            'pagination' => $this->paginationSerializer->toArray($statisticLabelsTable['pagination_data']),
            'items' => $statisticLabelsTable['pagination_data']->getItems(),
            'columns' => $statisticLabelsTable['columns'],
            'total' => $this->makeTotalStructure($statisticLabelsTable['total']),
        ];
    }
}