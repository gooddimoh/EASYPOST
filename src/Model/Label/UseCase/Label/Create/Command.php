<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\Create;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Label\UseCase\Label\Create
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $shipmentId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $shipmentRateId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderName;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $senderType;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderCode;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderPhone;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderEmail;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderStreet1;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderCity;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderState;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderCountry;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $senderZip;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientName;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $recipientType;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientCode;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientPhone;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientEmail;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientStreet1;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientCity;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientState;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientCountry;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $recipientZip;

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
     * @var int
     */
    public int $shipmentPrice;

    /**
     * @var string
     */
    public string $senderStreet2 = '';

    /**
     * @var string
     */
    public string $recipientStreet2 = '';

    /**
     * @var string
     */
    public string $description = '';

    /**
     * @var string
     */
    public string $service = '';

    /**
     * @var string
     */
    public string $carrier = '';

    /**
     * @var string
     */
    public string $track = '';

    /**
     * @var string
     */
    public string $trackUrl = '';

    /**
     * @var string
     */
    public string $labelUrl = '';

    /**
     * @var array
     */
    public array $options = [];

    /**
     * @var array
     */
    public array $packages = [];

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
