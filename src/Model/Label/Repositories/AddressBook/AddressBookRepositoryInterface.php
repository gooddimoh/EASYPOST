<?php

declare(strict_types=1);

namespace App\Model\Label\Repositories\AddressBook;

use App\Model\Label\Entity\AddressBook\AddressBook;
use App\Model\Label\Entity\AddressBook\Fields\Id;

/**
 * Interface LabelRepositoryInterface
 * @package App\Model\Label\Repositories\AddressBook
 */
interface AddressBookRepositoryInterface
{
    /**
     * @param Id $id
     * @return AddressBook
     */
    public function get(Id $id): AddressBook;

    /**
     * @param AddressBook $Label
     */
    public function add(AddressBook $Label): void;
}
