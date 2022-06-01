<?php

declare(strict_types=1);

namespace App\Model\Stripe\Repositories\Charge;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Stripe\Entity\Charge\Charge;
use App\Model\Stripe\Entity\Charge\Fields\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class ChargeRepository
 *
 * @package App\Model\Stripe\Repositories\Charge
 */
class ChargeRepository implements ChargeRepositoryInterface
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
        $this->repo = $em->getRepository(Charge::class);
        $this->em = $em;
    }

    /**
     * @param Charge $charge
     */
    public function add(Charge $charge): void
    {
        $this->em->persist($charge);
    }

    /**
     * @param string $stripeChargeId
     *
     * @return Charge|null
     */
    public function findByStripeId(string $stripeChargeId): ?Charge
    {
        return $this->repo->findOneBy([
            'stripeId.value' => $stripeChargeId
        ]);
    }

    /**
     * @param Id $id
     *
     * @return Charge
     */
    public function get(Id $id): Charge
    {
        if (!$charge = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Charge not found');
        }

        return $charge;
    }
}
