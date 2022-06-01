<?php

declare(strict_types=1);

namespace App\Infrastructure\IteratorRequest;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use Iterator;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class IteratorRequest
 * @package App\Infrastructure\IteratorRequest
 */
class IteratorRequest implements Iterator
{
    /**
     * @var array|false
     */
    private $current = false;

    /**
     * @var integer
     */
    private $page = 0;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var QueryBuilder
     */
    private $query;

    /**
     * @var int
     */
    private $limit = 50;

    /**
     * @param QueryBuilder $query
     */
    public function setQuery(QueryBuilder $query): void
    {
        $this->query = $query;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->page = 0;
        $this->data = [];
    }

    /**
     * Gets the next set of results.
     *
     * @throws InvalidRequestParameter
     * @return array|false
     */
    public function next()
    {
        if (!$this->query) {
            throw new InvalidRequestParameter("Set query");
        }

        $this->data = $this->query
            ->setFirstResult($this->page * $this->limit)
            ->setMaxResults($this->limit)
            ->execute()
            ->fetchAll();

        $this->page++;
        $this->current = $this->data ?: false;

        return $this->current;
    }

    /**
     * @return array|false
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->page;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return ($this->current !== false);
    }
}