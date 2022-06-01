<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Company\Balance;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Company\Entity\Company\Fields\Balance\Balance;
use App\Model\Company\Entity\Company\Fields\Id;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class CompanyRepository
 * @package App\Model\Company\Repositories\Company
 */
class BalanceRepository implements BalanceRepositoryInterface
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
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Balance::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     * @return Balance
     * @throws \Throwable
     */
    public function get(Id $id): Balance
    {
        try {
            if (!$balance = $this->repo->findOneBy(['company' => $id->getValue()])) {
                throw new EntityNotFoundException('Company not found');
            }
            $this->em->lock($balance, LockMode::PESSIMISTIC_WRITE);

            return $balance;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @param Balance $balance
     */
    public function add(Balance $balance): void
    {
        $this->em->persist($balance);
    }
}
