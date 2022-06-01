<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Customer;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\User\Entity\User\User;
use App\Model\Stripe\Entity\Customer\Fields\{StripeId, Id, Type, BankAccountToken, Status};
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 *
 * @package App\Model\Stripe\Entity\Customer
 *
 * @ORM\Entity
 * @ORM\Table(name="stripe_customers")
 */
class Customer extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="stripe_customer_id")
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
     * @var StripeId
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Customer\Fields\StripeId")
     */
    private StripeId $stripeId;

    /**
     * @var BankAccountToken
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Customer\Fields\BankAccountToken")
     */
    private BankAccountToken $bankAccountToken;

    /**
     * @var Type
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Customer\Fields\Type")
     */
    private Type $type;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Stripe\Entity\Customer\Fields\Status")
     */
    private Status $status;

    /**
     * @param Id               $id
     * @param User             $user
     * @param StripeId         $stripeId
     * @param BankAccountToken $bankAccountToken
     * @param Type             $type
     * @param Status           $status
     */
    public function __construct(
        Id               $id,
        User             $user,
        StripeId         $stripeId,
        BankAccountToken $bankAccountToken,
        Type             $type,
        Status           $status
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->stripeId = $stripeId;
        $this->bankAccountToken = $bankAccountToken;
        $this->type = $type;
        $this->status = $status;
    }

    /**
     * @param Status $status
     */
    public function changeStatus(Status $status): void
    {
        if ($this->status->isVerified()) {
            throw new \DomainException(
                'Can not change bank account status. This bank account has been already verified.'
            );
        }

        if ($this->status->isEqual($status)) {
            return;
        }

        $this->status = $status;
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
     * @return StripeId
     */
    public function getStripeId(): StripeId
    {
        return $this->stripeId;
    }

    /**
     * @return BankAccountToken
     */
    public function getBankAccountToken(): BankAccountToken
    {
        return $this->bankAccountToken;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }
}
