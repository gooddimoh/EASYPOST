<?php

declare(strict_types=1);


namespace App\ReadModels\User;

/**
 * Class DetailView
 * @package App\ReadModels\User
 */
class DetailView
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
    public string $createDate;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $role;

    /**
     * @var int
     */
    public int $status;
}
