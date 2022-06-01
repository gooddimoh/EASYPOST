<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Transaction\Pending;

use App\Model\Company\Entity\Company\Fields\Id as CompanyId;
use App\Model\Company\Entity\Transaction\Transaction;
use App\Model\Company\Repositories\Company\Balance\BalanceRepositoryInterface;
use App\Model\Company\Entity\Transaction\Fields\{Balance, Id, Type, Creator, Description, Status};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Repositories\Transaction\TransactionRepositoryInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Transaction\Pending
 */
class Handler
{
    /**
     * @var BalanceRepositoryInterface
     */
    private BalanceRepositoryInterface $balanceRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @var TransactionRepositoryInterface
     */
    private TransactionRepositoryInterface $transactionRepository;

    /**
     * Handler constructor.
     *
     * @param TransactionRepositoryInterface $transactionRepository
     * @param BalanceRepositoryInterface     $companyRepository
     * @param FlusherInterface               $flusher
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        BalanceRepositoryInterface     $companyRepository,
        FlusherInterface               $flusher
    ) {
        $this->flusher = $flusher;
        $this->transactionRepository = $transactionRepository;
        $this->balanceRepository = $companyRepository;
    }

    /**
     * @param Command $command
     *
     * @return Transaction
     * @throws Exception
     */
    public function handle(Command $command): Transaction
    {
        $companyId = $command->company ?? $command->modifiedCompany;
        $balance = $this->balanceRepository->get(new CompanyId($companyId));

        $transaction = new Transaction(
            Id::next(),
            new Description($command->description),
            new Balance($balance->getTotal(), $command->balance),
            Type::credit($command->method, $command->options),
            new Creator($command->modifiedId, $command->modifiedCompany),
            new DateTimeImmutable(),
            Status::pending(),
        );

        $this->transactionRepository->add($transaction);
        $this->flusher->flush($transaction);

        return $transaction;
    }
}
