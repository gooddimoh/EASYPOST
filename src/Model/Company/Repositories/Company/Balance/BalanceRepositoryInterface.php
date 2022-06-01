<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Company\Balance;

use App\Model\Company\Entity\Company\Fields\Balance\Balance;
use App\Model\Company\Entity\Company\Fields\Id;

/**
 * Interface BalanceRepositoryInterface
 * @package App\Model\Company\Repositories\Company
 */
interface BalanceRepositoryInterface
{
    /**
     * @param Id $id
     * @return Balance
     */
    public function get(Id $id): Balance;

    /**
     * @param Balance $balance
     */
    public function add(Balance $balance): void;
}
