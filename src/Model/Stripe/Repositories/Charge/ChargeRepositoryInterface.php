<?php

declare(strict_types=1);

namespace App\Model\Stripe\Repositories\Charge;

use App\Model\Stripe\Entity\Charge\Charge;
use App\Model\Stripe\Entity\Charge\Fields\Id;

/**
 * Interface ChargeRepositoryInterface
 *
 * @package App\Model\Stripe\Repositories\Charge
 */
interface ChargeRepositoryInterface
{
    /**
     * @param Charge $charge
     */
    public function add(Charge $charge): void;

    /**
     * @param string $stripeChargeId
     *
     * @return Charge|null
     */
    public function findByStripeId(string $stripeChargeId): ?Charge;

    /**
     * @param Id $id
     *
     * @return Charge
     */
    public function get(Id $id): Charge;
}
