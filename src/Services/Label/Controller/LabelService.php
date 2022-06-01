<?php

declare(strict_types=1);

namespace App\Services\Label\Controller;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\Label\LabelFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class AddressBook
 *
 * @package App\Services\AddressBook\Controller
 */
class LabelService
{
    /**
     * @var LabelFetcher
     */
    private LabelFetcher $fetcher;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * LabelService constructor.
     *
     * @param LabelFetcher $fetcher
     * @param Security     $security
     */
    public function __construct(
        LabelFetcher $fetcher,
        Security     $security
    ) {
        $this->fetcher = $fetcher;
        $this->security = $security;
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return PaginationInterface
     * @throws ExceptionInterface
     */
    public function getItems(PaginationRequestInterface $paginationRequest): PaginationInterface
    {
        $paginationRequest->getFilter()->addFilter($this->permissionFilters([]));

        return $this->fetcher->all($paginationRequest);
    }

    /**
     * @param string $id
     *
     * @return array
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getOne(string $id): array
    {
        $labelData = $this->fetcher->getOne($this->permissionFilters(['id' => $id]));

        if (!$labelData) {
            throw new EntityNotFoundException('Label not found.');
        }

        return $labelData;
    }

    /**
     * @param string|null $name
     * @param string      $id
     *
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getList(?string $name, string $id = ''): array
    {
        return $this->fetcher->getList($name, $id);
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return $this->fetcher->getTableColumns();
    }

    /**
     * @return array
     */
    public function getDraftTableColumns(): array
    {
        return $this->fetcher->getDraftTableColumns();
    }

    /**
     * @param array $filter
     * @return array
     */
    private function permissionFilters($filter = []): array
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $filter['company_id'] = $this->security->getUser()->getCompany();
        }

        return $filter;
    }
}
