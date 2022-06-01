<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Login\Create;

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

    /**
     * @var string
     */
    public string $session = '';

    /**
     * @var string
     */
    public string $city = '';

    /**
     * @var string
     */
    public string $country = '';

    /**
     * @var string
     */
    public string $browser = '';

    /**
     * @var string
     */
    public string $ipAddress = '';
}
