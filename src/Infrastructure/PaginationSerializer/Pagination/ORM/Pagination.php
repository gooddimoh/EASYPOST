<?php

declare(strict_types=1);


namespace App\Infrastructure\PaginationSerializer\Pagination\ORM;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use Doctrine\DBAL\Query\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface as PaginationORM;

/**
 * Class Pagination
 * @package App\Infrastructure\PaginationSerializer\Pagination\ORM
 */
class Pagination implements PaginationInterface
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * @var PaginationORM
     */
    private PaginationORM $pagination;

    /**
     * Pagination constructor.
     * @param PaginatorInterface $paginator
     */
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param QueryBuilder $query
     * @param PaginationRequestInterface $request
     * @return $this
     */
    public function paginate(QueryBuilder $query, PaginationRequestInterface $request): self
    {
        $this->pagination = $this->paginator->paginate(
            $query,
            $request->getPagination()->getPage(),
            $request->getPagination()->getSize()
        );

        return $this;
    }

    /**
     * @return iterable
     */
    public function getItems(): iterable
    {
        return $this->pagination->getItems();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->pagination->count();
    }

    /**
     * @return int
     */
    public function getTotalItemCount(): int
    {
        return $this->pagination->getTotalItemCount();
    }

    /**
     * @return int
     */
    public function getItemNumberPerPage(): int
    {
        return $this->pagination->getItemNumberPerPage();
    }

    /**
     * @return int
     */
    public function getCurrentPageNumber(): int
    {
        return $this->pagination->getCurrentPageNumber();
    }

    /**
     * @return int
     */
    public function getCurrentPagesNumber(): int
    {
        return (int)ceil($this->pagination->getTotalItemCount() / $this->pagination->getItemNumberPerPage());
    }
}
