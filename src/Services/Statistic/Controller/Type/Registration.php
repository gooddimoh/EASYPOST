<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Type;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\ReadModels\User\UserFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class Registration extends BaseType
{
    /**
     * @var UserFetcher $userFetcher
     */
    private UserFetcher $userFetcher;

    /**
     * @param UserFetcher $userFetcher
     */
    public function __construct(UserFetcher $userFetcher)
    {
        $this->userFetcher = $userFetcher;
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
        $user = $this->userFetcher->statistic(
            [
                'day_date as date',
                "json_build_object('registration', COALESCE(user_count, 0)) as items"
            ],
            $paginationRequest
        );

        return [
            'total' => $this->makeTotalStructure($user['total']),
            'graph' => $this->makeGraphStructure($user['graph'])
        ];
    }
}