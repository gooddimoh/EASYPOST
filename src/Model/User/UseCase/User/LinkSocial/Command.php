<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\LinkSocial;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\User\UseCase\User\LinkSocial
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\Email()
     */
    public string $email;

    /**
     * @var string
     */
    public string $socialId;

    /**
     * @var int
     */
    public int $type;
}
