<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Transaction;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Company\Entity\Transaction\Fields\Id;
use App\Model\Company\Entity\Transaction\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class TransactionRepository
 * @package App\Model\Company\Repositories\Transaction
 */
class TransactionRepository implements TransactionRepositoryInterface
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
        $this->repo = $em->getRepository(Transaction::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     * @return Transaction
     */
    public function get(Id $id): Transaction
    {
        if (!$company = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Company not found');
        }

        return $company;
    }

    /**
     * @param Transaction $transaction
     */
    public function add(Transaction $transaction): void
    {
        $this->em->persist($transaction);
    }
}
