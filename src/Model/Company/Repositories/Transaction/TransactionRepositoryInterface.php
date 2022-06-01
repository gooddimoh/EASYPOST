<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Transaction;

use App\Model\Company\Entity\Transaction\Transaction;
use App\Model\Company\Entity\Transaction\Fields\Id;

/**
 * Interface TransactionRepositoryInterface
 * @package App\Model\Company\Repositories\Company
 */
interface TransactionRepositoryInterface
{
    /**
     * @param Id $id
     * @return Transaction
     */
    public function get(Id $id): Transaction;

    /**
     * @param Transaction $transaction
     */
    public function add(Transaction $transaction): void;
}
