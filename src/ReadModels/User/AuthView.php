<?php

declare(strict_types=1);


namespace App\ReadModels\User;

use App\Infrastructure\Enums\Model\Company\TypeEnum;

/**
 * Class AuthView
 *
 * @package App\ReadModels\User
 */
class AuthView
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password_hash;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var string
     */
    public string $photo = '';

    /**
     * @var string
     */
    public string $company;

    /**
     * @var string|null
     */
    public ?string $company_name = '';

    /**
     * @var string
     */
    public string $role = '';

    /**
     * @var string|null
     */
    public ?string $active_package = '';

    /**
     * @var int
     */
    public int $status;

    /**
     * @var int
     */
    public int $company_type;

    /**
     * @var array
     */
    public array $permission = [];

    //TODO parser
    public function __set($name, $value)
    {
        if ($name === 'permissions' && $value) {
            $this->permission = json_decode($value);
        }
    }
}
