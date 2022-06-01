<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\AddressBook\Update;

use App\Model\Label\Entity\AddressBook\AddressBook;
use App\Model\Label\Entity\AddressBook\Fields\{Name, Options, Type, Id, Description, Contact, Address};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Label\Repositories\AddressBook\AddressBookRepositoryInterface;

/**
 * Class Handler
 * @package App\Model\Label\UseCase\Label\Update
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
     * @throws \Exception
     */
    public function handle(Command $command): AddressBook
    {
        $address = $this->addressBookRepository->get(new Id($command->id));

        $address->changeName(new Name($command->name));
        $address->changeType(new Type($command->type, $command->typeAddress));
        $address->changePhone(new Contact($command->code, $command->phone, $command->email));
        $address->changeDescription(new Description($command->description));

        $address->changeAddress(new Address(
            $command->street1,
            $command->street2,
            $command->city,
            $command->state,
            $command->country,
            $command->zip
        ));

        $address->mergeOptions(new Options($command->options));

        $this->addressBookRepository->add($address);
        $this->flusher->flush($address);

        return $address;
    }
}
