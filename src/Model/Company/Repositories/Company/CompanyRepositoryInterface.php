<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Company;

use App\Model\Company\Entity\Company\Company;
use App\Model\Company\Entity\Company\Fields\Id;

/**
 * Interface CompanyRepositoryInterface
 *
 * @package App\Model\Company\Repositories\Company
 */
interface CompanyRepositoryInterface
{
    /**
     * @param Id $id
     *
     * @return Company
     */
    public function get(Id $id): Company;

    /**
     * @param Company $Company
     */
    public function add(Company $Company): void;
}
