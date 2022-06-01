<?php

declare(strict_types=1);

namespace App\Services\User\Controller;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\User\UserFetcher;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class UserService
 * @package App\Services\User\Controller
 */
class UserService
{
    /**
     * @var UserFetcher
     */
    private UserFetcher $fetcher;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * UserService constructor.
     * @param UserFetcher $fetcher
     * @param Security $security
     */
    public function __construct(UserFetcher $fetcher, Security $security)
    {
        $this->fetcher = $fetcher;
        $this->security = $security;
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     * @return PaginationInterface
     * @throws ExceptionInterface
     */
    public function getItems(PaginationRequestInterface $paginationRequest): PaginationInterface
    {
        $paginationRequest->getFilter()->addFilter($this->permissionFilters([]));
        return $this->fetcher->all($paginationRequest);
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
            $filter['company_id'] = $this->security->getUser()->getCompany();
        }

        return $filter;
    }
}
