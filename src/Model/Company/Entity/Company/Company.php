<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\Company\Entity\Company\Fields\{Balance\Balance, Name, Id, Type, Photo, Creator, Package, Status};
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use DateTimeImmutable;

/**
 * Class Company
 *
 * @package App\Model\Company\Entity\Company
 *
 * @ORM\Entity
 * @ORM\Table(name="company_companies")
 */
class Company extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="company_company_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Name
     * @ORM\Embedded(class="App\Model\Company\Entity\Company\Fields\Name")
     */
    private Name $name;

    /**
     * @var Photo
     * @ORM\Embedded(class="App\Model\Company\Entity\Company\Fields\Photo")
     */
    private Photo $photo;

    /**
     * @var Type
     * @ORM\Embedded(class="App\Model\Company\Entity\Company\Fields\Type")
     */
    private Type $type;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\Company\Entity\Company\Fields\Status")
     */
    private Status $status;

    /**
     * @var Package
     * @ORM\Embedded(class="App\Model\Company\Entity\Company\Fields\Package", columnPrefix=false)
     */
    private Package $package;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Company\Entity\Company\Fields\Balance\Balance", mappedBy="company",
     *                                                                                       orphanRemoval=true,
     *                                                                                       cascade={"persist"})
     * @var Balance
     */
    private Balance $balance;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\Company\Entity\Company\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * Company constructor.
     *
     * @param Id                $id
     * @param Name              $name
     * @param Type              $type
     * @param Photo             $photo
     * @param Package           $package
     * @param Creator           $creator
     * @param DateTimeImmutable $date
     * @param Status            $status
     *
     * @throws \Exception
     */
    public function __construct(
        Id $id,
        Name $name,
        Type $type,
        Photo $photo,
        Package $package,
        Creator $creator,
        DateTimeImmutable $date,
        Status $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->photo = $photo;
        $this->package = $package;
        $this->status = $status;
        $this->user = $creator;
        $this->date = $date;

        $this->balance = new Balance(0, 0, $this);
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

        if (!$this->type->canChange($type)) {
            throw new DomainException("Can't change company type.");
        }

        $this->type = $type;
    }

    /**
     * @param Photo $photo
     */
    public function changePhoto(Photo $photo): void
    {
        if ($this->photo->isEqual($photo)) {
            return;
        }

        $this->photo = $photo;
    }

    /**
     * @param Status $status
     */
    public function changeStatus(Status $status): void
    {
        $this->status = $status;
    }

    /**
     * @param Package $package
     */
    public function changePackage(Package $package): void
    {
        if ($this->package->isEqual($package)) {
            return;
        }

        $this->package = $package;
    }

    /**
     * @param DateTimeImmutable $date
     */
    public function changeDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new DomainException('Company is already active.');
        }

        $this->changeStatus(Status::active());
    }

    public function block(): void
    {
        if ($this->isBlocked()) {
            throw new DomainException('Company is already blocked.');
        }

        $this->changeStatus(Status::block());
    }

    /**
     * @param Company $company
     *
     * @return bool
     */
    public function isEqual(Company $company): bool
    {
        return $this->getId()->getValue() === $company->getId()->getValue();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
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
     * @return Photo
     */
    public function getPhoto(): Photo
    {
        return $this->photo;
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
     * @return Package
     */
    public function getPackage(): Package
    {
        return $this->package;
    }

    /**
     * @return Balance
     */
    public function getBalance(): Balance
    {
        return $this->balance;
    }
}
