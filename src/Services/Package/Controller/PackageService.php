<?php

declare(strict_types=1);

namespace App\Services\Package\Controller;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\Package\PackageFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class PackageService
 *
 * @package App\Services\Package\Controller
 */
class PackageService
{
    /**
     * @var PackageFetcher
     */
    private PackageFetcher $fetcher;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * PackageService constructor.
     *
     * @param PackageFetcher $fetcher
     * @param Security       $security
     */
    public function __construct(PackageFetcher $fetcher, Security $security)
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
        $paginationRequest->getFilter()->addFilter($this->permissionFilters());

        return $this->fetcher->all($paginationRequest);
    }

    /**
     * @param string $id
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function getOne(string $id): array
    {
        $packageData = $this->fetcher->getOne($this->permissionFilters(['id' => $id]));

        if (!$packageData) {
            throw new EntityNotFoundException('Package not found.');
        }

        return $packageData;
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
        return $this->fetcher->getList($name, $id, $this->permissionFilters([]));
    }

    /**
     * @param string|null $companyId
     *
     * @return int
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getLabelPrice(?string $companyId = null): int
    {
        return $this->fetcher->getLabelPrice($companyId ?? $this->security->getUser()->getCompany());
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
     *
     * @return array
     */
    private function permissionFilters(array $filter = []): array
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $filter['available_company'] = '-';
        } elseif ($this->security->getUser()) {
            $filter['available_company'] = $this->security->getUser()->getCompany();
        }

        return $filter;
    }
}
