<?php

declare(strict_types=1);

namespace App\Services\Auth\DTO;

class SocialUser
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var int
     */
    public int $type;
}