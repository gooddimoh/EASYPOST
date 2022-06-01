<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\AddressBook;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\Label\Entity\AddressBook\Fields\{
    Id,
    Name,
    Type,
    Contact,
    Status,
    Creator,
    Address,
    Options,
    Description,
};
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use DateTimeImmutable;

/**
 * Class AddressBook
 * @package App\Model\Label\Entity\Label
 *
 * @ORM\Entity
 * @ORM\Table(name="label_address_books")
 */
class AddressBook extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="label_address_book_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Name
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Name")
     */
    private Name $name;

    /**
     * @var Type
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Type")
     */
    private Type $type;

    /**
     * @var Contact
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Contact")
     */
    private Contact $contact;

    /**
     * @var Address
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Address")
     */
    private Address $address;

    /**
     * @var Description
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Description")
     */
    private Description $description;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Status")
     */
    private Status $status;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * @var Options
     * @ORM\Embedded(class="App\Model\Label\Entity\AddressBook\Fields\Options")
     */
    private Options $options;

    /**
     * AddressBook constructor.
     * @param Id $id
     * @param Name $name
     * @param Type $type
     * @param Contact $phone
     * @param Address $address
     * @param Description $description
     * @param Status $status
     * @param Options $options
     * @param Creator $creator
     * @param DateTimeImmutable $date
     */
    public function __construct(
        Id $id,
        Name $name,
        Type $type,
        Contact $phone,
        Address $address,
        Description $description,
        Status $status,
        Options $options,
        Creator $creator,
        DateTimeImmutable $date
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->contact = $phone;
        $this->address = $address;
        $this->description = $description;
        $this->status = $status;
        $this->user = $creator;
        $this->date = $date;
        $this->options = $options;
    }

    /**
     * @param Status $status
     */
    public function changeStatus(Status $status): void
    {
        $this->status = $status;
    }

    /**
     * @param Name $name
     */
    public function changeName(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            return;
        }

        $this->name = $name;
    }

    /**
     * @param Type $type
     */
    public function changeType(Type $type): void
    {
        if ($this->type->isEqual($type)) {
            return;
        }

        $this->type = $type;
    }

    /**
     * @param Contact $phone
     */
    public function changePhone(Contact $phone): void
    {
        if ($this->contact->isEqual($phone)) {
            return;
        }

        $this->contact = $phone;
    }

    /**
     * @param Address $address
     */
    public function changeAddress(Address $address): void
    {
        if ($this->address->isEqual($address)) {
            return;
        }

        $this->address = $address;
    }

    /**
     * @param Description $description
     */
    public function changeDescription(Description $description): void
    {
        if ($this->description->isEqual($description)) {
            return;
        }

        $this->description = $description;
    }

    /**
     * @param Options $options
     */
    public function mergeOptions(Options $options): void
    {
        $options->merge($this->options);
        $this->options = $options;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new DomainException('Label is already active.');
        }

        $this->changeStatus(Status::active());
    }

    public function block(): void
    {
        if ($this->isBlocked()) {
            throw new DomainException('Label is already blocked.');
        }

        $this->changeStatus(Status::block());
    }

    /**
     * @param AddressBook $addressBook
     * @return bool
     */
    public function isEqual(AddressBook $addressBook): bool
    {
        return $this->getId()->getValue() === $addressBook->getId()->getValue();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->status->isBlocked();
    }

    /**
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Creator
     */
    public function getUser(): Creator
    {
        return $this->user;
    }
}
