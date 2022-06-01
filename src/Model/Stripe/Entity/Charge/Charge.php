<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Charge;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\User\Entity\User\User;
use App\Model\Stripe\Entity\Charge\Fields\{Data, StripeId, Id, Amount, Status, Transaction, Company, Customer};
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Charge
 *
 * @package App\Model\Stripe\Entity\Charge
 *
 * @ORM\Entity
 * @ORM\Table(name="stripe_charges")
 */
class Charge extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="stripe_charge_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Model\User\Entity\User\User")
     * @ORM\JoinColumn(name="user_id", onDelete="CASCADE", referencedColumnName="id")
     */
    private User $user;

    /**
     * @var Customer
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Charge\Fields\Customer")
     */
    private Customer $customer;

    /**
     * @var Transaction
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Charge\Fields\Transaction")
     */
    private Transaction $transaction;

    /**
     * @var Company
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Charge\Fields\Company")
     */
    private Company $company;

    /**
     * @var StripeId
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Charge\Fields\StripeId")
     */
    private StripeId $stripeId;

    /**
     * @var Amount
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Charge\Fields\Amount")
     */
    private Amount $amount;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Charge\Fields\Status")
     */
    private Status $status;

    /**
     * @var Data
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Charge\Fields\Data")
     */
    private Data $data;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @param Id                $id
     * @param User              $user
     * @param Company           $company
     * @param Transaction       $transaction
     * @param Customer          $customer
     * @param StripeId          $stripeId
     * @param Amount            $amount
     * @param Status            $status
     * @param Data              $data
     * @param DateTimeImmutable $date
     */
    public function __construct(
        Id                $id,
        User              $user,
        Company           $company,
        Transaction       $transaction,
        Customer          $customer,
        StripeId          $stripeId,
        Amount            $amount,
        Status            $status,
        Data              $data,
        DateTimeImmutable $date
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->company = $company;
        $this->transaction = $transaction;
        $this->customer = $customer;
        $this->stripeId = $stripeId;
        $this->amount = $amount;
        $this->status = $status;
        $this->data = $data;
        $this->date = $date;
    }

    /**
     * @param Status $status
     */
    public function changeStatus(Status $status): void
    {
        if (!$this->status->isPending()) {
            throw new \DomainException('Can not change charge status. Current status is not pending.');
        }

        if ($this->status->isEqual($status)) {
            return;
        }

        $this->status = $status;
    }

    /**
     * @param Data $data
     */
    public function changeData(Data $data): void
    {
        if ($this->data->isEqual($data)) {
            return;
        }

        $this->data = $data;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return StripeId
     */
    public function getStripeId(): StripeId
    {
        return $this->stripeId;
    }

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Data
     */
    public function getData(): Data
    {
        return $this->data;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
