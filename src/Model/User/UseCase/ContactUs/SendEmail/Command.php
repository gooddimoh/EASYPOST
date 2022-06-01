<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ContactUs\SendEmail;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\User\UseCase\ContactUs\SendEmail
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $fullName;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $message;
}
