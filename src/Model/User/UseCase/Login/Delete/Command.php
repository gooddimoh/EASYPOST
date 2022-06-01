<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Login\Delete;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\User\UseCase\Login\Create
 */
class Command implements DataObject
{
    /**
     * @var string
     */
    public string $id;
}
