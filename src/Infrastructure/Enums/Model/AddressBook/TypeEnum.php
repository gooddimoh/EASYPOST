<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\AddressBook;

final class TypeEnum
{
    const SENDER = 1;
    const RECIPIENT = 2;

    public static function getAll(): array
    {
        return [
            self::SENDER,
            self::RECIPIENT,
        ];
    }
}
