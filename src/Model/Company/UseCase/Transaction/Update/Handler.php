<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Transaction\Update;

use App\Model\Company\Entity\Company\Fields\Id as CompanyId;
use App\Model\Company\Entity\Transaction\Transaction;
use App\Model\Company\Repositories\Company\Balance\BalanceRepositoryInterface;
use App\Model\Company\Entity\Transaction\Fields\{Id, Status};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Repositories\Transaction\TransactionRepositoryInterface;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Transaction\Update
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
        $transaction = $this->transactionRepository->get(new Id($command->id));
        $balance = $this->balanceRepository->get(new CompanyId($transaction->getUser()->getCompany()));

        $newStatus = new Status($command->status);

        if ($newStatus->isSuccess()) {
            $transaction->success();
            $balance->add($transaction->getBalance()->getValue());
        } elseif ($newStatus->isFail()) {
            $transaction->fail();
        }

        $this->flusher->flush($transaction);

        return $transaction;
    }
}
