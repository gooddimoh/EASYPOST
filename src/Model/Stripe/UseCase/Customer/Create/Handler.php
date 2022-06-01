<?php

declare(strict_types=1);

namespace App\Model\Stripe\UseCase\Customer\Create;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Stripe\Entity\Customer\Customer;
use App\Model\User\Repositories\User\UserRepositoryInterface;
use App\Model\User\Entity\User\Fields\Id as UserId;
use App\Model\Stripe\Entity\Customer\Fields\{BankAccountToken, Id, Status, StripeId, Type};
use App\Model\Stripe\Repositories\Customer\CustomerRepositoryInterface;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Stripe\UseCase\Customer\Create
 */
class Handler
{
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param UserRepositoryInterface     $userRepository
     * @param FlusherInterface            $flusher
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        UserRepositoryInterface     $userRepository,
        FlusherInterface            $flusher
    ) {
        $this->flusher = $flusher;
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Command $command
     *
     * @return Customer
     * @throws Exception
     */
    public function handle(Command $command): Customer
    {
        $customer = $this->customerRepository->findByUser($command->userId, $command->type);

        if ($customer) {
            throw new \DomainException('Customer already exists.');
        }

        $user = $this->userRepository->get(new UserId($command->userId));

        $customer = new Customer(
            Id::next(),
            $user,
            new StripeId($command->stripeCustomerId),
            new BankAccountToken($command->bankAccountToken),
            new Type($command->type),
            new Status($command->status)
        );

        $this->customerRepository->add($customer);
        $this->flusher->flush($customer);

        return $customer;
    }
}
