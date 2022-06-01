<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\AddressBook;

final class AddressEnum
{
    const COMPANY = 1;
    const PERSON = 2;

    public static function getAll(): array
    {
        return [
            self::COMPANY,
            self::PERSON,
        ];
    }
}
