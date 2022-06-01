<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Transaction;

final class TypeEnum
{
    const DEBIT = 1;
    const CREDIT = 2;

    public static function getAll(): array
    {
        return [
            self::DEBIT,
            self::CREDIT,
        ];
    }
}
