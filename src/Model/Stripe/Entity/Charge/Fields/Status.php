<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Charge\Fields;

use App\Infrastructure\Enums\Model\Stripe\Charge\StatusEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Status
 *
 * @package App\Model\Stripe\Entity\Charge\Fields
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
     * @param self $value
     *
     * @return bool
     */
    public function isEqual(self $value): bool
    {
        return $this->value === $value->getValue();
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->value === StatusEnum::PENDING;
    }

    /**
     * @return static
     */
    public static function pending(): self
    {
        return new self(StatusEnum::PENDING);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
