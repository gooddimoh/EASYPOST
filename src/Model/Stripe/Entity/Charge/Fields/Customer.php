<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Charge\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Customer
 *
 * @package App\Model\Stripe\Entity\Charge\Fields
 * @ORM\Embeddable
 */
class Customer
{
    /**
     * @var string
     * @ORM\Column(type="guid", nullable=false)
     */
    private string $value;

    /**
     * Customer constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::uuid($value);

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
