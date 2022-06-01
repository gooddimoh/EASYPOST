<?php

declare(strict_types=1);

namespace App\Model\Stripe\UseCase\Charge\Update;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Stripe\Entity\Charge\Charge;
use App\Model\Stripe\Entity\Charge\Fields\{Data, Id, Status};
use App\Model\Stripe\Repositories\Charge\ChargeRepositoryInterface;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Stripe\UseCase\Charge\Update
 */
class Handler
{
    /**
     * @var ChargeRepositoryInterface
     */
    private ChargeRepositoryInterface $chargeRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @param ChargeRepositoryInterface $chargeRepository
     * @param FlusherInterface          $flusher
     */
    public function __construct(
        ChargeRepositoryInterface $chargeRepository,
        FlusherInterface          $flusher
    ) {
        $this->flusher = $flusher;
        $this->chargeRepository = $chargeRepository;
    }

    /**
     * @param Command $command
     *
     * @return Charge
     * @throws Exception
     */
    public function handle(Command $command): Charge
    {
        $charge = $this->chargeRepository->findByStripeId($command->stripeId);

        if (!$charge) {
            throw new \DomainException(sprintf('Charge - "%s" not found.', $command->stripeId));
        }

        $charge->changeStatus(new Status($command->status));
        $charge->changeData(new Data($command->data));

        $this->flusher->flush($charge);

        return $charge;
    }
}
