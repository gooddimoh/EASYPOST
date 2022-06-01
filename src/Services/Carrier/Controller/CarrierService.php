<?php

declare(strict_types=1);

namespace App\Services\Carrier\Controller;

use App\Infrastructure\Enums\Model\Carrier\TypeEnum;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\Carrier\CarrierFetcher;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class CarrierService
 *
 * @package App\Services\Carrier\Controller
 */
class CarrierService
{
    /**
     * @var CarrierFetcher
     */
    private CarrierFetcher $fetcher;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * UserService constructor.
     *
     * @param CarrierFetcher $fetcher
     * @param Security       $security
     */
    public function __construct(CarrierFetcher $fetcher, Security $security)
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
        $paginationRequest->getPagination()->changePagination(1, CarrierFetcher::LIMIT);

        return $this->fetcher->all($paginationRequest);
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
    public function getList(?string $name = null, string $id = ''): array
    {
        return $this->fetcher->getList($name, $id, ['company_id' => $this->security->getUser()->getCompany()]);
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
    private function getCarrierAccountTypes(): array
    {
        $types = [];

        if ($this->security->isGranted('ROLE_USE_USPS')) {
            $types[] = TypeEnum::USPS;
        }

        if ($this->security->isGranted('ROLE_USE_UPS')) {
            $types[] = TypeEnum::UPS;
        }

        if ($this->security->isGranted('ROLE_USE_FEDEX')) {
            $types[] = TypeEnum::FEDEX;
        }

        return $types;
    }

    /**
     * @param array $filter
     *
     * @return array
     */
    private function permissionFilters(array $filter = []): array
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $filter['company_id'] = $this->security->getUser()->getCompany();
            $filter['types'] = $this->getCarrierAccountTypes();
        } else {
            $filter['custom'] = false;
        }

        return $filter;
    }
}
