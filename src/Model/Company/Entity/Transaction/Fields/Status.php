<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Transaction\Fields;

use App\Infrastructure\Enums\Model\Transaction\StatusEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Status
 *
 * @package App\Model\Company\Entity\Transaction\Fields
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
    public function isSuccess(): bool
    {
        return $this->value === StatusEnum::SUCCESS;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->value === StatusEnum::PENDING;
    }

    /**
     * @return bool
     */
    public function isFail(): bool
    {
        return $this->value === StatusEnum::FAIL;
    }

    /**
     * @return Status
     */
    public static function success(): self
    {
        return new self(StatusEnum::SUCCESS);
    }

    /**
     * @return Status
     */
    public static function pending(): self
    {
        return new self(StatusEnum::PENDING);
    }

    /**
     * @return Status
     */
    public static function fail(): self
    {
        return new self(StatusEnum::FAIL);
    }
}
