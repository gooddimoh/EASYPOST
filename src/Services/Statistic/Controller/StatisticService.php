<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller;

use App\Infrastructure\Exceptions\InvalidRequestData;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Services\Permission\PermissionService;
use App\Services\Statistic\Controller\Role\Admin\Admin;
use App\Services\Statistic\Controller\Role\RoleInterface;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class StatisticService
{
    /**
     * @var array
     */
    private const ROLES = [
        'ROLE_ADMIN',
        'ROLE_COMPANY_OWNER',
        'ROLE_COMPANY_MANAGER',
    ];

    /**
     * @var PermissionService
     */
    private PermissionService $permissionService;

    /**
     * @var Admin
     */
    private Admin $admin;

    /**
     * @var array
     */
    private array $roles;

    /**
     * @param PermissionService $permissionService
     * @param Admin             $admin
     */
    public function __construct(
        PermissionService $permissionService,
        Admin             $admin
    ) {
        $this->permissionService = $permissionService;
        $this->admin = $admin;
        $this->roles = array_combine(self::ROLES, self::ROLES);
    }

    /**
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     * @throws \Doctrine\DBAL\Exception
     */
    public function wholeDashboard(): array
    {
        return $this->statisticByRole()->getData();
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     * @throws ExceptionInterface
     */
    public function income(PaginationRequestInterface $paginationRequest): array
    {
        if (!method_exists($this->statisticByRole(), __FUNCTION__)) {
            throw new InvalidRequestData('You are not authorized to receive these statistics.');
        }

        return $this->statisticByRole()->income($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     * @throws ExceptionInterface
     */
    public function credit(PaginationRequestInterface $paginationRequest): array
    {
        if (!method_exists($this->statisticByRole(), __FUNCTION__)) {
            throw new InvalidRequestData('You are not authorized to receive these statistics.');
        }

        return $this->statisticByRole()->credit($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     * @throws ExceptionInterface
     */
    public function registration(PaginationRequestInterface $paginationRequest): array
    {
        if (!method_exists($this->statisticByRole(), __FUNCTION__)) {
            throw new InvalidRequestData('You are not authorized to receive these statistics.');
        }

        return $this->statisticByRole()->registration($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     * @throws ExceptionInterface
     */
    public function label(PaginationRequestInterface $paginationRequest): array
    {
        if (!method_exists($this->statisticByRole(), __FUNCTION__)) {
            throw new InvalidRequestData('You are not authorized to receive these statistics.');
        }

        return $this->statisticByRole()->label($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     * @throws ExceptionInterface
     */
    public function carrier(PaginationRequestInterface $paginationRequest): array
    {
        if (!method_exists($this->statisticByRole(), __FUNCTION__)) {
            throw new InvalidRequestData('You are not authorized to receive these statistics.');
        }

        return $this->statisticByRole()->carrier($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws ExceptionInterface
     * @throws \JsonException
     */
    public function statisticLabel(PaginationRequestInterface $paginationRequest): array
    {
        if (!method_exists($this->statisticByRole(), __FUNCTION__)) {
            throw new InvalidRequestData('You are not authorized to receive these statistics.');
        }

        return $this->statisticByRole()->statisticLabel($paginationRequest);
    }

    /**
     * @return RoleInterface
     * @throws InvalidRequestData
     */
    private function statisticByRole(): RoleInterface
    {
        if ($this->permissionService->hasRoleAccess($this->roles['ROLE_ADMIN'])) {
            return $this->admin;
        }

        throw new InvalidRequestData('Statistic not found for current user.');
    }
}