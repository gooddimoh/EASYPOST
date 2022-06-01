<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class CarrierAccount
 *
 * @package App\Model\Label\Entity\Carrier\Fields
 * @ORM\Embeddable
 */
class CarrierAccount
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * CarrierAccount constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param self $value
     *
     * @return bool
     */
    public function isEqual(self $value): bool
    {
        return $this->value === $value->getValue();
    }
}
