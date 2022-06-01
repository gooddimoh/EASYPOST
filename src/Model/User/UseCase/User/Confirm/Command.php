<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Confirm;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements DataObject
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $code;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $phone;
}
