<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Reset\Request;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\User\UseCase\User\Reset\Request
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;
}
