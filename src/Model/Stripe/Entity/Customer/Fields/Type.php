<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Customer\Fields;

use App\Infrastructure\Enums\Model\Stripe\Customer\TypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Type
 *
 * @package App\Model\Stripe\Entity\Customer\Fields
 * @ORM\Embeddable
 */
class Type
{
    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $value;

    /**
     * Type constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::oneOf($value, TypeEnum::getAll());

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param self $type
     *
     * @return bool
     */
    public function isEqual(self $type): bool
    {
        return $this->value === $type->getValue();
    }
}
