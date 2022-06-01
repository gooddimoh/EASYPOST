<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields\Package\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Creator
 * @package App\Model\Label\Entity\Label\Fields\Package\Fields
 * @ORM\Embeddable
 */
class Quantity
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $value;

    /**
     * Creator constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::positiveInteger($value);

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
