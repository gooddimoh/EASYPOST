<?php

declare(strict_types=1);

namespace App\Model\Stripe\Repositories\Customer;

use App\Infrastructure\Enums\Model\Stripe\Customer\TypeEnum;
use App\Model\Stripe\Entity\Customer\Customer;
use App\Model\Stripe\Entity\Customer\Fields\Id;

/**
 * Interface CustomerRepositoryInterface
 *
 * @package App\Model\Stripe\Repositories\Customer
 */
interface CustomerRepositoryInterface
{
    /**
     * @param Customer $customer
     */
    public function add(Customer $customer): void;

    /**
     * @param string $stripeCustomerId
     *
     * @return Customer|null
     */
    public function findByStripeId(string $stripeCustomerId): ?Customer;

    /**
     * @param string $userId
     * @param int    $type
     *
     * @return Customer|null
     */
    public function findByUser(string $userId, int $type = TypeEnum::PLAID): ?Customer;

    /**
     * @param Id $id
     *
     * @return Customer
     */
    public function get(Id $id): Customer;
}
