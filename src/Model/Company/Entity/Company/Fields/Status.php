<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company\Fields;

use App\Infrastructure\Enums\Model\StatusEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Status
 * @package App\Model\Company\Entity\Company\Fields
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
     * @param int $value
     */
    private function __construct(int $value)
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
    public function isActive(): bool
    {
        return $this->value === StatusEnum::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->value === StatusEnum::BLOCK;
    }

    /**
     * @return Status
     */
    public static function active(): self
    {
        return new self(StatusEnum::ACTIVE);
    }

    /**
     * @return Status
     */
    public static function block(): self
    {
        return new self(StatusEnum::BLOCK);
    }
}
