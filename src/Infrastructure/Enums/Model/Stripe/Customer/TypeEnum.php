<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Stripe\Customer;

final class TypeEnum
{
    public const PLAID = 1;

    public const MANUAL = 2;

    public static function getAll(): array
    {
        return [
            self::PLAID,
            self::MANUAL,
        ];
    }
}
