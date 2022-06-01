<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\AddressBook\Create;

use App\Model\Label\Entity\AddressBook\AddressBook;
use App\Model\Label\Entity\AddressBook\Fields\{
    Creator,
    Name,
    Type,
    Id,
    Status,
    Description,
    Options,
    Contact,
    Address
};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Label\Repositories\AddressBook\AddressBookRepositoryInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 * @package App\Model\Label\UseCase\Label\Create
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
     * @throws Exception
     */
    public function handle(Command $command): AddressBook
    {
        $addressBook = new AddressBook(
            Id::next(),
            new Name(trim($command->name)),
            new Type($command->type, $command->typeAddress),
            new Contact($command->code, $command->phone, $command->email),
            new Address(
                $command->street1,
                $command->street2,
                $command->city,
                $command->state,
                $command->country,
                $command->zip
            ),
            new Description($command->description),
            Status::active(),
            new Options($command->options),
            new Creator($command->modifiedId, $command->modifiedCompany),
            new DateTimeImmutable(),
        );

        $this->addressBookRepository->add($addressBook);
        $this->flusher->flush($addressBook);

        return $addressBook;
    }
}
