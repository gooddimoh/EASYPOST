<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost\DTO\Pickup;

use App\Infrastructure\Integrations\EasyPost\DTO\Address;

/**
 * Class Pickup
 *
 * @package App\Infrastructure\Integrations\EasyPost\DTO\Pickup
 */
class Pickup
{
    /**
     * @var Address
     */
    private Address $from;

    /**
     * @var string
     */
    private string $instructions;

    /**
     * @var string
     */
    private string $maxDate;

    /**
     * @var string
     */
    private string $minDate;

    /**
     * @var string
     */
    private string $shipmentId;

    /**
     * Pickup constructor.
     *
     * @param Address $from
     * @param string  $shipmentId
     * @param string  $minDate
     * @param string  $maxDate
     * @param string  $instructions
     */
    public function __construct(
        Address $from,
        string $shipmentId,
        string $minDate,
        string $maxDate,
        string $instructions
    ) {
        $this->from = $from;
        $this->shipmentId = $shipmentId;
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->instructions = $instructions;
    }

    /**
     * @return Address
     */
    public function getFrom(): Address
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getInstructions(): string
    {
        return $this->instructions;
    }

    /**
     * @return string
     */
    public function getMaxDate(): string
    {
        return $this->maxDate;
    }

    /**
     * @return string
     */
    public function getMinDate(): string
    {
        return $this->minDate;
    }

    /**
     * @return string
     */
    public function getShipmentId(): string
    {
        return $this->shipmentId;
    }
}