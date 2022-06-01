<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Transaction;

final class StatusEnum
{
    public const FAIL = 0;

    public const PENDING = 1;

    public const SUCCESS = 2;

    public static function getAll(): array
    {
        return [
            self::FAIL,
            self::PENDING,
            self::SUCCESS,
        ];
    }
}
