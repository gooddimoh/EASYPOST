<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Package;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\Company\Entity\Package\Fields\{
    Name,
    Id,
    Price,
    Creator,
    AvailableCompany,
    Permissions,
    Status,
};
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * Class Package
 *
 * @package App\Model\Company\Entity\Package
 *
 * @ORM\Entity
 * @ORM\Table(name="company_packages")
 */
class Package extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="company_package_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Name
     * @ORM\Embedded(class="App\Model\Company\Entity\Package\Fields\Name")
     */
    private Name $name;

    /**
     * @var AvailableCompany
     * @ORM\Embedded(class="App\Model\Company\Entity\Package\Fields\AvailableCompany")
     */
    private AvailableCompany $availableCompany;

    /**
     * @var Price
     * @ORM\Embedded(class="App\Model\Company\Entity\Package\Fields\Price")
     */
    private Price $price;

    /**
     * @var Permissions
     * @ORM\Embedded(class="App\Model\Company\Entity\Package\Fields\Permissions")
     */
    private Permissions $permissions;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Company\Entity\Package\Fields\Status")
     */
    private Status $status;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\Company\Entity\Package\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * Package constructor.
     *
     * @param Id                $id
     * @param Name              $name
     * @param Price             $price
     * @param Permissions       $permissions
     * @param AvailableCompany  $availableCompany
     * @param Creator           $user
     * @param DateTimeImmutable $date
     * @param Status            $status
     */
    public function __construct(
        Id                $id,
        Name              $name,
        Price             $price,
        Permissions       $permissions,
        AvailableCompany  $availableCompany,
        Creator           $user,
        DateTimeImmutable $date,
        Status            $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->permissions = $permissions;
        $this->availableCompany = $availableCompany;
        $this->user = $user;
        $this->status = $status;
        $this->date = $date;
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
     * @param AvailableCompany $availableCompany
     */
    public function changeAvailableCompany(AvailableCompany $availableCompany): void
    {
        if ($this->availableCompany->isEqual($availableCompany)) {
            return;
        }

        $this->availableCompany = $availableCompany;
    }

    /**
     * @param Price $price
     */
    public function changePrice(Price $price): void
    {
        if ($this->price->isEqual($price)) {
            return;
        }

        $this->price = $price;
    }

    /**
     * @param Permissions $permissions
     */
    public function changePermission(Permissions $permissions): void
    {
        if ($this->permissions->isEqual($permissions)) {
            return;
        }

        $this->permissions = $permissions;
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
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @return Permissions
     */
    public function getPermissions(): Permissions
    {
        return $this->permissions;
    }

    /**
     * @return AvailableCompany
     */
    public function getAvailableCompany(): AvailableCompany
    {
        return $this->availableCompany;
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
