<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields\Package\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Price
 *
 * @package App\Model\Label\Entity\Label\Fields\Package\Fields
 * @ORM\Embeddable
 */
class Price
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $value;

    /**
     * Price constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::greaterThan($value, 0);

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
