<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company\Fields\Balance;

use App\Infrastructure\Events\AggregateRoot;
use App\Infrastructure\Exceptions\BalanceAmountException;
use App\Infrastructure\Services\UuidGenerator;
use App\Model\Company\Entity\Company\Company;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Balance
 *
 * @package App\Model\Label\Entity\Label
 *
 * @ORM\Entity
 * @ORM\Table(name="company_company_balances")
 */
class Balance extends AggregateRoot
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $total;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $lock;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Company\Entity\Company\Company", inversedBy="balance")
     * @ORM\JoinColumn(name="company_company_id", referencedColumnName="id", nullable=false)
     * @var Company
     */
    private Company $company;

    /**
     * Balance constructor.
     *
     * @param int     $balance
     * @param int     $lock
     * @param Company $company
     *
     * @throws \Exception
     */
    public function __construct(
        int $balance,
        int $lock,
        Company $company
    ) {
        Assert::greaterThanEq($balance, 0);
        Assert::greaterThanEq($lock, 0);

        $this->id = UuidGenerator::generate();

        $this->total = $balance;
        $this->lock = $lock;
        $this->company = $company;
    }

    /**
     * @param int $amount
     */
    public function add(int $amount): void
    {
        Assert::greaterThanEq($amount, 0);

        $this->total += $amount;
    }

    /**
     * @param int $amount
     */
    public function sub(int $amount): void
    {
        if (!$this->checkTotal($amount)) {
            throw new BalanceAmountException('Amount exceeds the balance.');
        }

        $this->total -= $amount;
    }

    /**
     * @param int $amount
     */
    public function lock(int $amount): void
    {
        if (!$this->checkTotal($amount)) {
            throw new BalanceAmountException('Amount exceeds the balance.');
        }

        $this->lock += $amount;
    }

    /**
     * @param int $amount
     */
    public function unlock(int $amount): void
    {
        $this->lock -= $amount;

        Assert::greaterThanEq($this->lock, 0);
    }

    /**
     * @param int $value
     *
     * @return bool
     */
    public function checkTotal(int $value): bool
    {
        Assert::greaterThanEq($value, 0);

        $balance = $this->total - $this->lock;

        return $value <= $balance;
    }

    /**
     * @param Balance $balance
     *
     * @return bool
     */
    public function isEqual(self $balance): bool
    {
        return $this->getId() === $balance->getId();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getLock(): int
    {
        return $this->lock;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }
}
