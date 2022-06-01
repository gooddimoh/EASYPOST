<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Reset\Reset;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\User\UseCase\User\Reset\Reset
 */
class Command implements DataObject
{
    /**
     * @var string
     */
    public string $token;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    public string $password;

    public function setToken(string $token)
    {
        $this->token = $token;
    }
}
