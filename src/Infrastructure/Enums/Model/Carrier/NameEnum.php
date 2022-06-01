<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Carrier;

/**
 * Class NameEnum
 *
 * @package App\Infrastructure\Enums\Model\Carrier
 */
final class NameEnum
{
    public const FEDEX = 'FedEx';

    public const UPS = 'UPS';

    public const USPS = 'USPS';

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
