<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Stripe\Customer;

final class StatusEnum
{
    public const NOT_VERIFIED = 0;

    public const VERIFIED = 1;

    public static function getAll(): array
    {
        return [
            self::NOT_VERIFIED,
            self::VERIFIED,
        ];
    }
}
