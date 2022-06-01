<?php

declare(strict_types=1);

namespace App\Model\Label\Repositories\Carrier;

use App\Model\Label\Entity\Carrier\Carrier;
use App\Model\Label\Entity\Carrier\Fields\Id;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Interface CarrierRepositoryInterface
 *
 * @package App\Model\Label\Repositories\Carrier
 */
interface CarrierRepositoryInterface
{
    /**
     * @param Carrier $carrier
     */
    public function add(Carrier $carrier): void;

    /**
     * @param string $companyId
     * @param string $type
     *
     * @return bool
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function existsCustom(string $companyId, string $type): bool;

    /**
     * @param Id $id
     *
     * @return Carrier
     */
    public function get(Id $id): Carrier;
}
