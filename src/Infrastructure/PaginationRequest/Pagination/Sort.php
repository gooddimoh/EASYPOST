<?php

declare(strict_types=1);

namespace App\Infrastructure\PaginationRequest\Pagination;

/**
 * Class Sort
 * @package App\Infrastructure\PaginationRequest\Pagination
 */
class Sort
{
    /**
     * @var string
     */
    private $column;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var Sort|null
     */
    private ?Sort $subSort = null;

    /**
     * Sort constructor.
     * @param array $sort
     */
    public function __construct(array $sort)
    {
        $this->column = $sort['column'] ?? '';
        $this->direction = $sort['direction'] ?? '';

        if (isset($sort['subSort'])) {
            $this->subSort = new Sort($sort['subSort']);
        }
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return Sort|null
     */
    public function getSubSort(): ?Sort
    {
        return $this->subSort;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !($this->column && $this->direction);
    }
}
