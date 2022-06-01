<?php

declare(strict_types=1);

namespace App\Services\Company\Controller;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\Company\CompanyFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class CompanyService
 *
 * @package App\Services\Company\Controller
 */
class CompanyService
{
    /**
     * @var CompanyFetcher
     */
    private CompanyFetcher $fetcher;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * CompanyService constructor.
     *
     * @param CompanyFetcher $fetcher
     * @param Security $security
     */
    public function __construct(
        CompanyFetcher $fetcher,
        Security $security
    )
    {
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
     * @param string|null $name
     * @param string $id
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
     * @param string|null $companyId
     *
     * @return int
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getBalance(?string $companyId = null): int
    {
        return $this->fetcher->getBalance($companyId ?? $this->security->getUser()->getCompany());
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return $this->fetcher->getTableColumns();
    }

    /**
     * @param array $filter
     * @return array
     */
    private function permissionFilters(array $filter = []): array
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $filter['id'] = $this->security->getUser()->getCompany();
        }

        return $filter;
    }
}
