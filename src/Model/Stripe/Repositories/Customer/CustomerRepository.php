<?php

declare(strict_types=1);

namespace App\Model\Stripe\Repositories\Customer;

use App\Infrastructure\Enums\Model\Stripe\Customer\TypeEnum;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Stripe\Entity\Customer\Customer;
use App\Model\Stripe\Entity\Customer\Fields\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class CustomerRepository
 *
 * @package App\Model\Label\Repositories\Carrier
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var EntityRepository
     */
    private EntityRepository $repo;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Customer::class);
        $this->em = $em;
    }

    /**
     * @param Customer $customer
     */
    public function add(Customer $customer): void
    {
        $this->em->persist($customer);
    }

    /**
     * @param string $stripeCustomerId
     *
     * @return Customer|null
     */
    public function findByStripeId(string $stripeCustomerId): ?Customer
    {
        return $this->repo->findOneBy([
            'stripeId.value' => $stripeCustomerId
        ]);
    }

    /**
     * @param string $userId
     * @param int    $type
     *
     * @return Customer|null
     */
    public function findByUser(string $userId, int $type = TypeEnum::PLAID): ?Customer
    {
        return $this->repo->findOneBy([
            'user' => $userId,
            'type.value' => $type
        ]);
    }

    /**
     * @param Id $id
     *
     * @return Customer
     */
    public function get(Id $id): Customer
    {
        if (!$customer = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Customer not found');
        }

        return $customer;
    }
}
