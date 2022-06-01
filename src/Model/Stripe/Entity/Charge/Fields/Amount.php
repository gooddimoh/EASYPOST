<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Charge\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Amount
 *
 * @package App\Model\Stripe\Entity\Charge\Fields
 * @ORM\Embeddable
 */
class Amount
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::greaterThanEq($value, 0);

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
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
