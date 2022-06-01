<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Type;

use App\Infrastructure\Enums\Model\Carrier\NameEnum;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\ReadModels\Label\LabelFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class Carrier extends BaseType
{
    /**
     * @var LabelFetcher
     */
    private LabelFetcher $labelFetcher;

    /**
     * @param LabelFetcher $labelFetcher
     */
    public function __construct(LabelFetcher $labelFetcher)
    {
        $this->labelFetcher = $labelFetcher;
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
        $carriers = $this->labelFetcher->statisticCarriers(
            [
                'day_date as date',
                sprintf(
                    "json_build_object('%s', COALESCE(usps_count, 0), '%s', COALESCE(ups_count, 0), '%s', COALESCE(fedex_count, 0)) as items",
                    NameEnum::USPS,
                    NameEnum::UPS,
                    NameEnum::FEDEX,
                )
            ],
            $paginationRequest
        );

        return [
            'total' => $this->makeTotalStructure($carriers['total']),
            'graph' => $this->makeGraphStructure($carriers['graph'])
        ];
    }
}