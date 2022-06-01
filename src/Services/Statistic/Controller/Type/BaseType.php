<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Type;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

abstract class BaseType
{
    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    abstract public function getData(PaginationRequestInterface $paginationRequest): array;

    /**
     * @param string $data
     *
     * @return array
     * @throws \JsonException
     */
    protected function makeTotalStructure(string $data): array
    {
        $decodeItems = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        return [
            'items' => array_map(
                static fn($key, $value) => ['name' => $key, 'value' => $value],
                array_keys($decodeItems),
                $decodeItems
            )
        ];
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \JsonException
     */
    protected function makeGraphStructure(array $data): array
    {
        $indexByDate = array_column($data, null, 'date');
        $decodeItems = array_map(
            static fn($item) => ['items' => json_decode($item['items'], true, 512, JSON_THROW_ON_ERROR)],
            $indexByDate
        );

        return array_map(
            static fn($items) => array_map(
                static fn($item) => array_map(
                    static fn($key, $value) => ['name' => $key, 'value' => $value],
                    array_keys($item),
                    $item
                ),
                $items
            ),
            $decodeItems
        );
    }
}