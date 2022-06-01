<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\AddressBook\Update;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\Label\UseCase\Label\Update
 */
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
    public string $street1;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $type;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $typeAddress;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $city;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $state;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $zip;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedCompany;

    /**
     * @var string
     */
    public string $street2 = '';

    /**
     * @var string
     */
    public string $country = '';

    /**
     * @var string
     */
    public string $code = '';

    /**
     * @var string
     */
    public string $phone = '';

    /**
     * @var string
     */
    public string $email = '';

    /**
     * @var string
     */
    public string $description = '';

    /**
     * @var array
     */
    public array $options = [];
}
