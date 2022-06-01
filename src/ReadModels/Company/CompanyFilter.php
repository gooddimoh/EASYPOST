<?php

declare(strict_types=1);


namespace App\ReadModels\Company;

/**
 * Class CompanyFilter
 * @package App\ReadModels\Company
 */
class CompanyFilter
{
    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var int|null
     */
    public ?int $type = null;

    /**
     * @var array|null
     */
    public ?array $status = null;

    /**
     * @var string|null
     */
    public ?string $date = null;
}
