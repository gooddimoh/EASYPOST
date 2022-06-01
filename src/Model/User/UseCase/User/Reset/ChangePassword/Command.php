<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Reset\ChangePassword;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\User\UseCase\User\Reset\ChangePassword
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
    public string $csrfToken;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    public string $oldPassword;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    public string $password;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     * @Assert\Expression(
     *     "not (this.getPassword() != this.getPasswordRepeat())",
     *     message="Password must be equal"
     * )
     */
    public $passwordRepeat;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPasswordRepeat(): string
    {
        return $this->passwordRepeat;
    }
}
