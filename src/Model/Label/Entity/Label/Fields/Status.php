<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Status
 *
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Status
{
    /**
     * @var array
     */
    public const ITEMS = [
        'ACTIVE' => 10,
        'DRAFT' => 5,
        'BLOCK' => 0,
    ];

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
    private function __construct(int $value)
    {
        Assert::oneOf($value, self::ITEMS);

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
        return $this->value === self::ITEMS['ACTIVE'];
    }

    /**
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->value === self::ITEMS['DRAFT'];
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->value === self::ITEMS['BLOCK'];
    }

    /**
     * @return Status
     */
    public static function active(): self
    {
        return new self(self::ITEMS['ACTIVE']);
    }

    /**
     * @return Status
     */
    public static function draft(): self
    {
        return new self(self::ITEMS['DRAFT']);
    }

    /**
     * @return Status
     */
    public static function block(): self
    {
        return new self(self::ITEMS['BLOCK']);
    }
}
