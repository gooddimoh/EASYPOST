<?php

declare(strict_types=1);

namespace App\Model\Stripe\UseCase\Customer\Update;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Stripe\Entity\Customer\Customer;
use App\Model\Stripe\Entity\Customer\Fields\Status;
use App\Model\Stripe\Repositories\Customer\CustomerRepositoryInterface;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Stripe\UseCase\Customer\Update
 */
class Handler
{
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param FlusherInterface            $flusher
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        FlusherInterface            $flusher
    ) {
        $this->flusher = $flusher;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param Command $command
     *
     * @return Customer
     * @throws Exception
     */
    public function handle(Command $command): Customer
    {
        $customer = $this->customerRepository->findByStripeId($command->stripeId);

        if (!$customer) {
            throw new \DomainException(sprintf('Customer - "%s" not found.', $command->stripeId));
        }

        $customer->changeStatus(new Status($command->status));

        $this->flusher->flush($customer);

        return $customer;
    }
}
