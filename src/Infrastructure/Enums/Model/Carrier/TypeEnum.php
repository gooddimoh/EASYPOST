<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Carrier;

/**
 * Class TypeEnum
 *
 * @package App\Infrastructure\Enums\Model\Carrier
 */
final class TypeEnum
{
    const FEDEX = 'FedexAccount';

    const UPS = 'UpsAccount';

    const USPS = 'UspsAccount';

    /**
     * @return int[]
     */
    public static function getAll(): array
    {
        return [
            self::UPS,
            self::FEDEX,
            self::USPS,
        ];
    }
}
