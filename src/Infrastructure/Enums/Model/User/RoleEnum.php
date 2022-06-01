<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\User;

final class RoleEnum
{
    const ADMIN = "ROLE_ADMIN";
    const OWNER = "ROLE_COMPANY_OWNER";
    const MANAGER = "ROLE_COMPANY_MANAGER";

    public static function getAll(): array
    {
        return [
            self::ADMIN,
            self::OWNER,
            self::MANAGER,
        ];
    }
}
