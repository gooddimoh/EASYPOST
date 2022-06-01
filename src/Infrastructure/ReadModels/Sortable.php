<?php

declare(strict_types=1);


namespace App\Infrastructure\ReadModels;


use App\Infrastructure\PaginationRequest\Pagination\Sort;
use Doctrine\DBAL\Query\QueryBuilder;

trait Sortable
{
    /**
     * @var Sort|null
     */
    private ?Sort $defaultSort = null;

    /**
     * @param QueryBuilder $queryBuilder
     * @param Sort $sort
     */
    private function setSort(QueryBuilder $queryBuilder, Sort $sort): void
    {
        $_sort = ($this->defaultSort && $sort->isEmpty()) ? $this->defaultSort : $sort;
        $this->querySort($queryBuilder, $_sort);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param Sort $sort
     */
    private function querySort(QueryBuilder $queryBuilder, Sort $sort): void
    {
        $column = $sort->getColumn();
        $direction = $sort->getDirection();
        $subSort = $sort->getSubSort();

        if ($column && in_array($column, $this->getTableColumns()) && $direction) {
            $queryBuilder->addOrderBy($column, $direction);
        }

        if ($subSort) {
            $this->querySort($queryBuilder, $subSort);
        }
    }

    /**
     * @param string $column
     * @param string $direction
     * @param array $subSort
     */
    private function setDefaultSort(string $column, string $direction, array $subSort = []): void
    {
        $this->defaultSort = new Sort([
            'column' => $column,
            'direction' => $direction,
            'subSort' => $subSort
        ]);
    }
}
