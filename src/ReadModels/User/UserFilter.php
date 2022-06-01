<?php

declare(strict_types=1);

namespace App\ReadModels\User;

/**
 * Class UserFilter
 *
 * @package App\ReadModels\User
 */
class UserFilter
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
     * @var array|null
     */
    public ?array $status = null;

    /**
     * @var string|null
     */
    public ?string $company = null;

    /**
     * @var string|null
     */
    public ?string $companyId = null;

    /**
     * @var string|null
     */
    public ?string $role = null;

    /**
     * @var string|null
     */
    public ?string $createDate = null;

    /**
     * @var string|null
     */
    public ?string $email = null;

    /**
     * @var string|null
     */
    public ?string $count = null;

    /**
     * @var array|null
     */
    public ?array $exclude = null;

    /**
     * @var string|null
     */
    public ?string $dateFrom = null;

    /**
     * @var string|null
     */
    public ?string $dateTo = null;
}
