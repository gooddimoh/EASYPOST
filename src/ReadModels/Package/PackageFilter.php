<?php

declare(strict_types=1);

namespace App\ReadModels\Package;

/**
 * Class PackageFilter
 *
 * @package App\ReadModels\Package
 */
class PackageFilter
{
    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var string|null
     */
    public ?string $availableCompany = null;

    /**
     * @var string|null
     */
    public ?string $priceMonth = null;

    /**
     * @var string|null
     */
    public ?string $priceLabel = null;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var string|null
     */
    public ?string $date = null;

    /**
     * @var string|null
     */
    public ?string $companyId = null;

    /**
     * @var string|null
     */
    public ?string $userId = null;

    /**
     * @var array|null
     */
    public ?array $status = null;
}
