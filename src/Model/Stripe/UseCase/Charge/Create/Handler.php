<?php

declare(strict_types=1);

namespace App\Model\Stripe\UseCase\Charge\Create;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Stripe\Entity\Charge\Charge;
use App\Model\Stripe\Entity\Charge\Fields\{Company, Customer, Data, StripeId, Id, Amount, Status, Transaction};
use App\Model\Stripe\Repositories\Charge\ChargeRepositoryInterface;
use App\Model\User\Repositories\User\UserRepositoryInterface;
use App\Model\User\Entity\User\Fields\Id as UserId;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Stripe\UseCase\Charge\Create
 */
class Handler
{
    /**
     * @var ChargeRepositoryInterface
     */
    private ChargeRepositoryInterface $chargeRepository;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @param ChargeRepositoryInterface $chargeRepository
     * @param UserRepositoryInterface   $userRepository
     * @param FlusherInterface          $flusher
     */
    public function __construct(
        ChargeRepositoryInterface $chargeRepository,
        UserRepositoryInterface   $userRepository,
        FlusherInterface          $flusher
    ) {
        $this->flusher = $flusher;
        $this->chargeRepository = $chargeRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Command $command
     *
     * @return Charge
     * @throws Exception
     */
    public function handle(Command $command): Charge
    {
        $user = $this->userRepository->get(new UserId($command->userId));

        $charge = new Charge(
            Id::next(),
            $user,
            new Company($command->companyId),
            new Transaction($command->transactionId),
            new Customer($command->customerId),
            new StripeId($command->stripeChargeId),
            new Amount($command->amount),
            Status::pending(),
            new Data($command->data),
            new \DateTimeImmutable()
        );

        $this->chargeRepository->add($charge);
        $this->flusher->flush($charge);

        return $charge;
    }
}
