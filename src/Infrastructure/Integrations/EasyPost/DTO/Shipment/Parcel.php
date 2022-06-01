<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost\DTO\Shipment;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Factory\PrimitiveTypes\Decimal;

/**
 * Class Parcel
 *
 * @package App\Infrastructure\Integrations\EasyPost\DTO\Shipment
 */
class Parcel
{
    /**
     * @var string|null
     */
    private ?string $height;

    /**
     * @var string|null
     */
    private ?string $length;

    /**
     * @var string
     */
    private string $weight;

    /**
     * @var string|null
     */
    private ?string $width;

    /**
     * Parcel constructor.
     *
     * @param string      $weight
     * @param string|null $length
     * @param string|null $width
     * @param string|null $height
     */
    public function __construct(
        string $weight,
        ?string $length = null,
        ?string $width = null,
        ?string $height = null
    ) {
        $this->weight = Decimal::create($weight)->mul(16)->toString(); // переводим в унции
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;

        $this->check();
    }

    /**
     * @return string|null
     */
    public function getHeight(): ?string
    {
        return $this->height;
    }

    /**
     * @return string|null
     */
    public function getLength(): ?string
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getWeight(): string
    {
        return $this->weight;
    }

    /**
     * @return string|null
     */
    public function getWidth(): ?string
    {
        return $this->width;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }

    private function check(): void
    {
        if (
            (is_null($this->length) && is_null($this->width) && is_null($this->height)) ||
            (!is_null($this->length) && !is_null($this->width) && !is_null($this->height))
        ) {
            //TODO подумать...
        } else {
            throw new InvalidRequestParameter('All dimensions must be specified.');
        }
    }
}