<?php

declare(strict_types=1);

namespace App\Model\Label\Repositories\Label;

use App\Model\Label\Entity\Label\Label;
use App\Model\Label\Entity\Label\Fields\Id;

/**
 * Interface LabelRepositoryInterface
 * @package App\Model\Label\Repositories\AddressBook
 */
interface LabelRepositoryInterface
{
    /**
     * @param Id $id
     * @return Label
     */
    public function get(Id $id): Label;

    /**
     * @param Label $label
     */
    public function add(Label $label): void;
}
