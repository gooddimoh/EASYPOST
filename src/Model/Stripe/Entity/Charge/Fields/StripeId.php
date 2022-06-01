<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Charge\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class StripeId
 *
 * @package App\Model\Stripe\Entity\Charge\Fields
 * @ORM\Embeddable
 */
class StripeId
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * StripeId constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
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

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
