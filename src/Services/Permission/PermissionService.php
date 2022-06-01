<?php

declare(strict_types=1);

namespace App\Services\Permission;

use Symfony\Component\Security\Core\Security;

class PermissionService
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param string      $role
     * @param string|null $companyId
     *
     * @return bool
     */
    public function hasRoleAccess(string $role, ?string $companyId = null): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        $user = $this->security->getUser();

        if (!$user) {
            return false;
        }

        if ($this->security->isGranted($role)) {
            if ($companyId) {
                return $user->getCompany() === $companyId;
            }

            return true;
        }

        return false;
    }

    /**
     * @param string $userId
     *
     * @return bool
     */
    public function hasUserAccess(string $userId): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        $user = $this->security->getUser();

        if (!$user) {
            return false;
        }

        return $user->getId() === $userId;
    }
}
