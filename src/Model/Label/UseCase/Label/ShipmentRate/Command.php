<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\ShipmentRate;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Label\UseCase\Label\ShipmentRate
 */
class Command implements DataObject
{
    /**
     * @var array
     */
    public array $availableCarriers;

    /**
     * @var int
     */
    public int $companyLabelPrice;

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
     * @var array
     */
    public array $options = [];

    /**
     * @var array
     */
    public array $packages = [];

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientCity;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientCode;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientCountry;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientEmail;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientPhone;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientState;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientStreet1;

    /**
     * @var string
     */
    public string $recipientStreet2 = '';

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $recipientType;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientZip;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderCity;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderCode;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderCountry;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderEmail;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderPhone;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderState;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderStreet1;

    /**
     * @var string
     */
    public string $senderStreet2 = '';

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $senderType;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderZip;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $type;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Positive
     */
    public string $weight;

    /**
     * @var string|null
     */
    public ?string $length = null;

    /**
     * @var string|null
     */
    public ?string $width = null;

    /**
     * @var string|null
     */
    public ?string $height = null;
}
