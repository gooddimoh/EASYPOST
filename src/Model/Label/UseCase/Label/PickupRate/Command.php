<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\PickupRate;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Label\UseCase\Label\PickupRate
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $instructions;

    /**
     * @var string
     * @Assert\DateTime()
     */
    public string $maxDate;

    /**
     * @var string
     * @Assert\DateTime()
     */
    public string $minDate;

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
}
