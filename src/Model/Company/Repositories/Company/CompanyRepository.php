<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Company;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Company\Entity\Company\Fields\Id;
use App\Model\Company\Entity\Company\Company;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class CompanyRepository
 *
 * @package App\Model\Company\Repositories\Company
 */
class CompanyRepository implements CompanyRepositoryInterface
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
     * CompanyRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Company::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     *
     * @return Company
     */
    public function get(Id $id): Company
    {
        if (!$company = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Company not found');
        }

        return $company;
    }

    /**
     * @param Company $Company
     */
    public function add(Company $Company): void
    {
        $this->em->persist($Company);
    }
}
