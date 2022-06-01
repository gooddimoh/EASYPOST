<?php

declare(strict_types=1);

namespace App\Model\Label\Repositories\Carrier;

use App\Infrastructure\Enums\Model\StatusEnum;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Label\Entity\Carrier\Fields\Id;
use App\Model\Label\Entity\Carrier\Carrier;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Class CarrierRepository
 *
 * @package App\Model\Label\Repositories\Carrier
 */
class CarrierRepository implements CarrierRepositoryInterface
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
     * CarrierRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Carrier::class);
        $this->em = $em;
    }

    /**
     * @param Carrier $carrier
     */
    public function add(Carrier $carrier): void
    {
        $this->em->persist($carrier);
    }

    /**
     * @param string $companyId
     * @param string $type
     *
     * @return bool
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function existsCustom(string $companyId, string $type): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->where('t.user.company = :company')
                ->andWhere('t.type.value = :type')
                ->andWhere('t.custom.value = :custom')
                ->andWhere('t.status.value = :status')
                ->setParameter(':company', $companyId)
                ->setParameter(':type', $type)
                ->setParameter(':custom', true, 'boolean')
                ->setParameter(':status', StatusEnum::ACTIVE)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    /**
     * @param Id $id
     *
     * @return Carrier
     */
    public function get(Id $id): Carrier
    {
        if (!$carrier = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Carrier not found');
        }

        return $carrier;
    }
}
