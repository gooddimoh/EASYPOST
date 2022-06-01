<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Transaction\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Balance
 *
 * @package App\Model\Company\Entity\Transaction\Fields
 * @ORM\Embeddable
 */
class Balance
{
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $history;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $value;

    /**
     * Balance constructor.
     *
     * @param int $balance
     * @param int $value
     */
    public function __construct(int $balance, int $value)
    {
        Assert::greaterThanEq($value, 0);

        $this->history = $balance;
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
     * @return int
     */
    public function getHistory(): int
    {
        return $this->history;
    }
}
