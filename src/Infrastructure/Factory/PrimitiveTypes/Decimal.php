<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory\PrimitiveTypes;

use Decimal\Decimal as DecimalBase;

class Decimal
{
    /**
     * @param DecimalBase|string|int $value
     * @param int $precision
     * @return DecimalBase
     */
    public static function create($value, int $precision = 28): DecimalBase
    {
        return new DecimalBase($value, $precision);
    }
}
