<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Parcel
 *
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Parcel
{
    /**
     * @var string|null
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private ?string $height;

    /**
     * @var string|null
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private ?string $length;

    /**
     * @var string
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     */
    private string $weight;

    /**
     * @var string|null
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
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
        string  $weight,
        ?string $length,
        ?string $width,
        ?string $height
    ) {
        Assert::numeric($weight);
        Assert::greaterThan($weight, 0);

        Assert::nullOrNumeric($length);
        Assert::nullOrGreaterThanEq($length, 0);

        Assert::nullOrNumeric($width);
        Assert::nullOrGreaterThanEq($width, 0);

        Assert::nullOrNumeric($height);
        Assert::nullOrGreaterThanEq($height, 0);

        $this->weight = $weight;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;

        $this->check();
    }

    /**
     * @param Parcel $parcel
     *
     * @return bool
     */
    public function isEqual(self $parcel): bool
    {
        return $this->weight === $parcel->getWeight() &&
            $this->length === $parcel->getLength() &&
            $this->width === $parcel->getWidth() &&
            $this->height === $parcel->getHeight();
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

    private function check(): void
    {
        if (
            (is_null($this->length) && is_null($this->width) && is_null($this->height)) ||
            (!is_null($this->length) && !is_null($this->width) && !is_null($this->height))
        ) {
            //TODO подумать...
        } else {
            throw new \DomainException('All dimensions must be specified.');
        }
    }
}
