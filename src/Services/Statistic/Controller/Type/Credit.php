<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Type;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\ReadModels\Transaction\TransactionFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class Credit extends BaseType
{
    /**
     * @var TransactionFetcher
     */
    private TransactionFetcher $transactionFetcher;

    /**
     * @param TransactionFetcher $transactionFetcher
     */
    public function __construct(TransactionFetcher $transactionFetcher)
    {
        $this->transactionFetcher = $transactionFetcher;
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
        $credit = $this->transactionFetcher->statistic(
            [
                'day_date as date',
                "json_build_object('credit', COALESCE(credit_balance, 0)) as items"
            ],
            $paginationRequest
        );

        return [
            'total' => $this->makeTotalStructure($credit['total']),
            'graph' => $this->makeGraphStructure($credit['graph'])
        ];
    }
}