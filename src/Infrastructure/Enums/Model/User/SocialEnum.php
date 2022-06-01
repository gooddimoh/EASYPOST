<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\User;

final class SocialEnum
{
    public const FACEBOOK = 1;

    public const GOOGLE = 2;

    public const STRING_PRESENTATION = [
        self::FACEBOOK => 'facebook',
        self::GOOGLE => 'google',
    ];

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::FACEBOOK,
            self::GOOGLE,
        ];
    }
}
