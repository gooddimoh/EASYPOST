<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Customer\Fields;

use App\Infrastructure\Enums\Model\Stripe\Customer\StatusEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Status
 *
 * @package App\Model\Stripe\Entity\Customer\Fields
 * @ORM\Embeddable
 */
class Status
{
    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $value;

    /**
     * Status constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::oneOf($value, StatusEnum::getAll());

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
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->value === StatusEnum::VERIFIED;
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
