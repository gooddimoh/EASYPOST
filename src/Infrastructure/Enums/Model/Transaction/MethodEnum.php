<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Transaction;

final class MethodEnum
{
    const CARD = 1;
    const BANK_TRANSFER = 2;
    const BANK_TRANSFER_MANUAL_VERIFICATION = 3;
    const PayPal = 4;
    const BITCOIN = 5;
    const ADMIN = 6;

    public static function getAll(): array
    {
        return [
            self::CARD,
            self::BANK_TRANSFER,
            self::BANK_TRANSFER_MANUAL_VERIFICATION,
            self::PayPal,
            self::BITCOIN,
            self::ADMIN,
        ];
    }
}
