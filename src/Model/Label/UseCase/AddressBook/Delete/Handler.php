<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\AddressBook\Delete;

use App\Model\Label\Entity\AddressBook\AddressBook;
use App\Model\Label\Entity\AddressBook\Fields\Status;
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Label\Entity\AddressBook\Fields\Id;
use App\Model\Label\Repositories\AddressBook\AddressBookRepositoryInterface;

/**
 * Class Handler
 * @package App\Model\Label\UseCase\Label\Delete
 */
class Handler
{
    /**
     * @var AddressBookRepositoryInterface
     */
    private AddressBookRepositoryInterface $addressBookRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     * @param AddressBookRepositoryInterface $addressBookRepository
     * @param FlusherInterface $flusher
     */
    public function __construct(
        AddressBookRepositoryInterface $addressBookRepository,
        FlusherInterface $flusher
    )
    {
        $this->flusher = $flusher;
        $this->addressBookRepository = $addressBookRepository;
    }

    /**
     * @param Command $command
     * @return AddressBook
     */
    public function handle(Command $command): AddressBook
    {
        $addressBook = $this->addressBookRepository->get(new Id($command->id));
        $addressBook->changeStatus(Status::block());

        $this->addressBookRepository->add($addressBook);

        $this->flusher->flush($addressBook);

        return $addressBook;
    }
}
