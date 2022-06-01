<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Type;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\ReadModels\Label\LabelFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class Income extends BaseType
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
        $income = $this->labelFetcher->statisticIncome(
            [
                'day_date as date',
                "json_build_object('subscription', COALESCE(subscription_sum, 0), 'label', COALESCE(price_label_sum, 0), 'additional', COALESCE(price_additional_sum, 0)) as items"
            ],
            $paginationRequest
        );

        return [
            'total' => $this->makeTotalStructure($income['total']),
            'graph' => $this->makeGraphStructure($income['graph'])
        ];
    }
}