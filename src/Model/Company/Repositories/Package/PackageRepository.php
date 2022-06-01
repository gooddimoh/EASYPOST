<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Package;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Company\Entity\Package\Package;
use App\Model\Company\Entity\Package\Fields\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class PackageRepository
 *
 * @package App\Model\Company\Repositories\Package
 */
class PackageRepository implements PackageRepositoryInterface
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $repo;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * PackageRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Package::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     *
     * @return Package
     */
    public function get(Id $id): Package
    {
        if (!$package = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Package not found');
        }

        return $package;
    }

    /**
     * @param Package $package
     */
    public function add(Package $package): void
    {
        $this->em->persist($package);
    }
}
