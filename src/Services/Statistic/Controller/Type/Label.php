<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Type;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\ReadModels\Label\LabelFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class Label extends BaseType
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
        $labels = $this->labelFetcher->statisticLabels(
            [
                'day_date as date',
                "json_build_object('label', COALESCE(label_count, 0)) as items"
            ],
            $paginationRequest
        );

        return [
            'total' => $this->makeTotalStructure($labels['total']),
            'graph' => $this->makeGraphStructure($labels['graph'])
        ];
    }
}