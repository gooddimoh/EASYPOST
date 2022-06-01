<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model;

final class StatusEnum
{
    const ACTIVE = 10;
    const BLOCK = 0;

    public static function getAll(): array
    {
        return [
            self::ACTIVE,
            self::BLOCK,
        ];
    }
}
