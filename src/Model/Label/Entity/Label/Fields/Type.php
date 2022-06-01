<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Type
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Type
{
    const TYPE_ITEMS = [
        'DOMESTIC_US_LABEL' => 1,
        'WORLD_LABEL' => 2,
    ];

    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $value;

    /**
     * Type constructor.
     * @param int $type
     */
    public function __construct(int $type)
    {
        Assert::oneOf($type, self::TYPE_ITEMS);

        $this->value = $type;
    }


    /**
     * @param self $type
     * @return bool
     */
    public function isEqual(self $type): bool
    {
        return $this->value === $type->getValue();
    }

    /**
     * @return bool
     */
    public function isDomesticUS(): bool
    {
        return $this->value === self::TYPE_ITEMS['DOMESTIC_US_LABEL'];
    }

    /**
     * @return bool
     */
    public function isWorld(): bool
    {
        return $this->value === self::TYPE_ITEMS['WORLD_LABEL'];
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
