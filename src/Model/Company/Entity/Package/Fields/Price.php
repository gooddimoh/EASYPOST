<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Package\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Price
 *
 * @package App\Model\Company\Entity\Package\Fields
 * @ORM\Embeddable
 */
class Price
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $month;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $label;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $additional;

    /**
     * Price constructor.
     *
     * @param int $month
     * @param int $label
     * @param int $additional
     */
    public function __construct(int $month, int $label, int $additional)
    {
        Assert::greaterThanEq($month, 0);
        Assert::greaterThanEq($label, 0);
        Assert::greaterThanEq($additional, 0);

        $this->month = $month;
        $this->label = $label;
        $this->additional = $additional;
    }

    /**
     * @param self $price
     *
     * @return bool
     */
    public function isEqual(self $price): bool
    {
        return $this->month === $price->getMonth() &&
            $this->label === $price->getLabel() &&
            $this->additional === $price->getAdditional();
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getLabel(): int
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getAdditional(): int
    {
        return $this->additional;
    }
}
