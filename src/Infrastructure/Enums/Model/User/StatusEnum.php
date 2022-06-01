<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\User;

final class StatusEnum
{
    public const BLOCK = 0;

    public const UNCONFIRMED = 5;

    public const ACTIVE = 10;

    public static function getAll(): array
    {
        return [
            self::BLOCK,
            self::UNCONFIRMED,
            self::ACTIVE,
        ];
    }
}
