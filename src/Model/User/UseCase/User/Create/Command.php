<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Create;

use App\Infrastructure\ObjectResolver\DataObject;

/**
 * Class Command
 *
 * @package App\Model\User\UseCase\User\Create
 */
class Command implements DataObject
{
    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $company;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var string|null
     */
    public ?string $modifiedId = null;

    /**
     * @var string
     */
    public string $photo = '';

    /**
     * @var string
     */
    public string $phoneCode = '';

    /**
     * @var string
     */
    public string $number = '';

    /**
     * @var string
     */
    public string $role = '';
}
