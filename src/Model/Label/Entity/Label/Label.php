<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label;

use App\Infrastructure\Events\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\Label\Entity\Label\Fields\{
    Id,
    Type,
    Parcel,
    Shipment,
    Pickup,
    Status,
    Options,
    Creator,
    Description,
    Destination,
    Information,
};
use App\Model\Label\Entity\Label\Fields\Package\Package;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use DateTimeImmutable;

/**
 * Class Label
 *
 * @package App\Model\Label\Entity\Label
 *
 * @ORM\Entity
 * @ORM\Table(name="label_labels")
 */
class Label extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="label_label_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Type
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Type")
     */
    private Type $type;

    /**
     * @var Shipment
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Shipment")
     */
    private Shipment $shipment;

    /**
     * @var Pickup
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Pickup")
     */
    private Pickup $pickup;

    /**
     * @var Parcel
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Parcel")
     */
    private Parcel $parcel;

    /**
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Destination")
     * @var Destination
     */
    private Destination $sender;

    /**
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Destination")
     * @var Destination
     */
    private Destination $recipient;

    /**
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Information")
     * @var Information
     */
    private Information $information;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Label\Entity\Label\Fields\Package\Package", mappedBy="label",
     *                                                                                    orphanRemoval=true,
     *                                                                                    cascade={"persist"})
     * @var Package[]|ArrayCollection
     */
    private $packages;

    /**
     * @var Description
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Description")
     */
    private Description $description;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Status")
     */
    private Status $status;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * @var Options
     * @ORM\Embedded(class="App\Model\Label\Entity\Label\Fields\Options")
     */
    private Options $options;

    /**
     * Label constructor.
     *
     * @param Id                $id
     * @param Type              $type
     * @param Shipment          $shipment
     * @param Parcel            $parcel
     * @param Destination       $sender
     * @param Destination       $recipient
     * @param Information       $information
     * @param Description       $description
     * @param Status            $status
     * @param Options           $options
     * @param DateTimeImmutable $date
     * @param Creator           $user
     */
    public function __construct(
        Id                $id,
        Type              $type,
        Shipment          $shipment,
        Parcel            $parcel,
        Destination       $sender,
        Destination       $recipient,
        Information       $information,
        Description       $description,
        Status            $status,
        Options           $options,
        DateTimeImmutable $date,
        Creator           $user
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->shipment = $shipment;
        $this->parcel = $parcel;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->information = $information;
        $this->description = $description;
        $this->status = $status;
        $this->options = $options;
        $this->date = $date;
        $this->user = $user;
        $this->pickup = new Pickup();

        $this->packages = new ArrayCollection();
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
     * @param Destination $sender
     */
    public function changeSender(Destination $sender): void
    {
        if ($this->sender->isEqual($sender)) {
            return;
        }

        $this->sender = $sender;
    }

    /**
     * @param Destination $recipient
     */
    public function changeRecipient(Destination $recipient): void
    {
        if ($this->recipient->isEqual($recipient)) {
            return;
        }

        $this->recipient = $recipient;
    }

    /**
     * @param Parcel $parcel
     */
    public function changeParcel(Parcel $parcel): void
    {
        if ($this->parcel->isEqual($parcel)) {
            return;
        }

        $this->parcel = $parcel;
    }

    /**
     * @param Pickup $pickup
     */
    public function changePickup(Pickup $pickup): void
    {
        $this->pickup = $pickup;
    }

    /**
     * @param Information $information
     */
    public function changeInformation(Information $information): void
    {
        if ($this->information->isEqual($information)) {
            return;
        }

        $this->information = $information;
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
    public function changeOptions(Options $options): void
    {
        if ($this->options->isEqual($options)) {
            return;
        }

        $this->options = $options;
    }

    /**
     * @param Options $options
     */
    public function mergeOptions(Options $options): void
    {
        $options->merge($this->options);
        $this->options = $options;
    }

    /**
     * @param Package[] $packages
     */
    public function changePackages(array $packages): void
    {
        if ($this->isDomesticUS()) {
            throw new DomainException('Label is domestic.');
        }

        if (!count($packages)) {
            throw new DomainException('Packages are empty.');
        }

        $this->packages->clear();
        foreach ($packages as $package) {
            $this->packages->add($package);
        }
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

        if (!$this->isDraft()) {
            throw new DomainException('Only draft labels can be deleted.');
        }

        $this->changeStatus(Status::block());
    }

    /**
     * @param Label $label
     *
     * @return bool
     */
    public function isEqual(Label $label): bool
    {
        return $this->getId()->getValue() === $label->getId()->getValue();
    }

    /**
     * @return bool
     */
    public function isDomesticUS(): bool
    {
        return $this->type->isDomesticUS();
    }

    /**
     * @return bool
     */
    public function isWorld(): bool
    {
        return $this->type->isWorld();
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
    public function isDraft(): bool
    {
        return $this->status->isDraft();
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
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
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

    /**
     * @return Shipment
     */
    public function getShipment(): Shipment
    {
        return $this->shipment;
    }

    /**
     * @return Pickup
     */
    public function getPickup(): Pickup
    {
        return $this->pickup;
    }

    /**
     * @return Parcel
     */
    public function getParcel(): Parcel
    {
        return $this->parcel;
    }

    /**
     * @return Destination
     */
    public function getSender(): Destination
    {
        return $this->sender;
    }

    /**
     * @return Destination
     */
    public function getRecipient(): Destination
    {
        return $this->recipient;
    }

    /**
     * @return Package[]|ArrayCollection
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @return Information
     */
    public function getInformation(): Information
    {
        return $this->information;
    }

    /**
     * @param Status $status
     */
    private function changeStatus(Status $status): void
    {
        $this->status = $status;
    }
}
