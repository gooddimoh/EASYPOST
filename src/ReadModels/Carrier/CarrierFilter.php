<?php

declare(strict_types=1);

namespace App\ReadModels\Carrier;

/**
 * Class CarrierFilter
 *
 * @package App\ReadModels\Carrier
 */
class CarrierFilter
{
    /**
     * @var string|null
     */
    public ?string $companyId = null;

    /**
     * @var bool|null
     */
    public ?bool $custom = null;

    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var int|null
     */
    public ?int $status = null;

    /**
     * @var array
     */
    public array $types = [];
}
