<?php

declare(strict_types=1);

namespace App\Model\Company\Repositories\Package;

use App\Model\Company\Entity\Package\Package;
use App\Model\Company\Entity\Package\Fields\Id;

/**
 * Interface PackageRepositoryInterface
 *
 * @package App\Model\Company\Repositories\Package
 */
interface PackageRepositoryInterface
{
    /**
     * @param Id $id
     *
     * @return Package
     */
    public function get(Id $id): Package;

    /**
     * @param Package $package
     */
    public function add(Package $package): void;
}
