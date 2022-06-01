<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Transaction;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\Company\Entity\Transaction\Fields\{
    Description,
    Id,
    Type,
    Balance,
    Creator,
    Status,
};
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use DateTimeImmutable;

/**
 * Class Company
 *
 * @package App\Model\Company\Entity\Transaction
 *
 * @ORM\Entity
 * @ORM\Table(name="company_company_transactions")
 */
class Transaction extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="company_transaction_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Description
     * @ORM\Embedded(class="App\Model\Company\Entity\Transaction\Fields\Description")
     */
    private Description $description;

    /**
     * @var Balance
     * @ORM\Embedded(class="App\Model\Company\Entity\Transaction\Fields\Balance")
     */
    private Balance $balance;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Company\Entity\Transaction\Fields\Status")
     */
    private Status $status;

    /**
     * @var Type
     * @ORM\Embedded(class="App\Model\Company\Entity\Transaction\Fields\Type")
     */
    private Type $type;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\Company\Entity\Transaction\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * Company constructor.
     *
     * @param Id                $id
     * @param Description       $name
     * @param Balance           $balance
     * @param Type              $type
     * @param Creator           $creator
     * @param DateTimeImmutable $date
     * @param Status            $status
     */
    public function __construct(
        Id                $id,
        Description       $name,
        Balance           $balance,
        Type              $type,
        Creator           $creator,
        DateTimeImmutable $date,
        Status            $status
    ) {
        $this->id = $id;
        $this->description = $name;
        $this->balance = $balance;
        $this->type = $type;
        $this->status = $status;
        $this->user = $creator;
        $this->date = $date;
    }

    /**
     * @param Description $name
     */
    public function changeDescription(Description $name): void
    {
        if ($this->description->isEqual($name)) {
            return;
        }

        $this->description = $name;
    }

    public function success(): void
    {
        if ($this->isSuccess()) {
            throw new DomainException('Transaction is already success.');
        }

        $this->changeStatus(Status::success());
    }

    public function pending(): void
    {
        if ($this->isPending()) {
            throw new DomainException('Transaction is already pending.');
        }

        $this->changeStatus(Status::pending());
    }

    public function fail(): void
    {
        if ($this->isFail()) {
            throw new DomainException('Transaction is already fail.');
        }

        $this->changeStatus(Status::fail());
    }

    /**
     * @param Transaction $transaction
     *
     * @return bool
     */
    public function isEqual(Transaction $transaction): bool
    {
        return $this->getId()->getValue() === $transaction->getId()->getValue();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->status->isSuccess();
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status->isPending();
    }

    /**
     * @return bool
     */
    public function isFail(): bool
    {
        return $this->status->isFail();
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return Balance
     */
    public function getBalance(): Balance
    {
        return $this->balance;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Creator
     */
    public function getUser(): Creator
    {
        return $this->user;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Status $status
     */
    private function changeStatus(Status $status): void
    {
        $this->status = $status;
    }
}
