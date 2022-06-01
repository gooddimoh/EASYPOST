<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\Label\Entity\Carrier\Fields\{CarrierAccount,
    Credentials,
    Custom,
    Editable,
    Id,
    Name,
    Type,
    Status,
    Creator,
    Description
};
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * Class Carrier
 *
 * @package App\Model\Label\Entity\Carrier
 *
 * @ORM\Entity
 * @ORM\Table(name="label_carriers")
 */
class Carrier extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="label_carrier_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Name
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Name")
     */
    private Name $name;

    /**
     * @var Type
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Type")
     */
    private Type $type;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Status")
     */
    private Status $status;

    /**
     * @var CarrierAccount
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\CarrierAccount")
     */
    private CarrierAccount $carrierAccount;

    /**
     * @var Credentials
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Credentials")
     */
    private Credentials $credentials;

    /**
     * @var Custom
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Custom")
     */
    private Custom $custom;

    /**
     * @var Description
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Description")
     */
    private Description $description;

    /**
     * @var Editable
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Editable")
     */
    private Editable $editable;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\Label\Entity\Carrier\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * Carrier constructor.
     *
     * @param Id                $id
     * @param Name              $name
     * @param Type              $type
     * @param Description       $description
     * @param CarrierAccount    $carrierAccount
     * @param Credentials       $credentials
     * @param Custom            $custom
     * @param Editable          $editable
     * @param Status            $status
     * @param DateTimeImmutable $date
     * @param Creator           $user
     */
    public function __construct(
        Id $id,
        Name $name,
        Type $type,
        Description $description,
        CarrierAccount $carrierAccount,
        Credentials $credentials,
        Custom $custom,
        Editable $editable,
        Status $status,
        DateTimeImmutable $date,
        Creator $user
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->carrierAccount = $carrierAccount;
        $this->credentials = $credentials;
        $this->custom = $custom;
        $this->editable = $editable;
        $this->status = $status;
        $this->date = $date;
        $this->user = $user;
    }

    public function block(): void
    {
        if ($this->status->isBlocked()) {
            throw new \DomainException('Carrier already blocked.');
        }

        $this->status = Status::block();
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->editable->getValue();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return CarrierAccount
     */
    public function getCarrierAccount(): CarrierAccount
    {
        return $this->carrierAccount;
    }

    /**
     * @return Credentials
     */
    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @return Custom
     */
    public function getCustom(): Custom
    {
        return $this->custom;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return Editable
     */
    public function getEditable(): Editable
    {
        return $this->editable;
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
