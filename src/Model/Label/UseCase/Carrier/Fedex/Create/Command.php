<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Carrier\Fedex\Create;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Label\UseCase\Carrier\Fedex\Create
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $accountNumber;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $key;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $meterNumber;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedCompany;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $password;
}
