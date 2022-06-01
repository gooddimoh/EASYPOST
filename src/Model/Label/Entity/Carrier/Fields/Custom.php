<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Custom
 *
 * @package App\Model\Label\Entity\Carrier\Fields
 * @ORM\Embeddable
 */
class Custom
{
    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $value;

    /**
     * @return static
     */
    public static function no(): self
    {
        return new self(false);
    }

    /**
     * @return static
     */
    public static function yes(): self
    {
        return new self(true);
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * Custom constructor.
     *
     * @param bool $value
     */
    private function __construct(bool $value)
    {
        $this->value = $value;
    }
}
