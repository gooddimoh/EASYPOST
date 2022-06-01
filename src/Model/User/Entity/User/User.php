<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use App\Infrastructure\Events\AggregateRoot;

//use App\Model\User\Entity\User\Events\Create\EventCreateUser;
//use App\Model\User\Entity\User\Events\Update\EventChangeEmail;
//use App\Model\User\Entity\User\Events\Update\EventChangeName;
//use App\Model\User\Entity\User\Events\Update\EventChangePermissions;
//use App\Model\User\Entity\User\Events\Update\EventChangePhone;
//use App\Model\User\Entity\User\Events\Update\EventChangePhoto;
//use App\Model\User\Entity\User\Events\Update\EventChangeStatus;
use App\Model\User\Entity\User\Fields\{
    Name,
    Id,
    PasswordHash,
    ResetToken,
    Photo,
    Creator,
    Status,
    Phone,
    Role,
    Email,
    Company,
};
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use DateTimeImmutable;

/**
 * Class User
 *
 * @package App\Model\User\Entity\User
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user_users",uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email_value"}, options={"where": "(status_value = 10)"}),
 *     @ORM\UniqueConstraint(columns={"reset_token_token"})
 * })
 */
class User extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="user_user_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Name
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Name")
     */
    private Name $name;

    /**
     * @var ResetToken|null
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\ResetToken")
     */
    private ?ResetToken $resetToken;

    /**
     * @var Photo
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Photo")
     */
    private Photo $photo;

    /**
     * @var Company
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Company")
     */
    private Company $company;

    /**
     * @var Email
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Email")
     */
    private Email $email;

    /**
     * @var PasswordHash
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\PasswordHash")
     */
    private PasswordHash $passwordHash;

    /**
     * @var Phone
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Phone")
     */
    private Phone $phone;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Status")
     */
    private Status $status;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * @var Role
     * @ORM\Embedded(class="App\Model\User\Entity\User\Fields\Role")
     */
    private Role $role;

    /**
     * User constructor.
     *
     * @param Id                $id
     * @param Name              $name
     * @param PasswordHash      $passwordHash
     * @param Company           $company
     * @param Email             $email
     * @param Phone             $phone
     * @param Photo             $photo
     * @param Role              $role
     * @param Creator           $creator
     * @param DateTimeImmutable $date
     * @param Status            $status
     */
    public function __construct(
        Id                $id,
        Name              $name,
        PasswordHash      $passwordHash,
        Company           $company,
        Email             $email,
        Phone             $phone,
        Photo             $photo,
        Role              $role,
        Creator           $creator,
        DateTimeImmutable $date,
        Status            $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->passwordHash = $passwordHash;
        $this->company = $company;
        $this->email = $email;
        $this->phone = $phone;
        $this->photo = $photo;
        $this->status = $status;
        $this->user = $creator;
        $this->date = $date;
        $this->role = $role;

//        $this->recordEvent(new EventCreateUser($this));
    }

    /**
     * @param Name $name
     */
    public function changeName(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            return;
        }

//        $this->recordEvent(new EventChangeName($this->id, $this->name, $name));

        $this->name = $name;
    }

    /**
     * @param Photo $photo
     */
    public function changePhoto(Photo $photo): void
    {
        if ($this->photo->isEqual($photo)) {
            return;
        }
//        $this->recordEvent(new EventChangePhoto($this->id, $this->photo, $photo));

        $this->photo = $photo;
    }

    /**
     * @param Email $email
     */
    public function changeEmail(Email $email): void
    {
        if ($this->email->isEqual($email)) {
            return;
        }

//        $this->recordEvent(new EventChangeEmail($this->id, $this->email, $email));

        $this->email = $email;
    }

    /**
     * @param Phone $phone
     */
    public function changePhone(Phone $phone): void
    {
        if ($this->phone->isEqual($phone)) {
            return;
        }

//        $this->recordEvent(new EventChangePhone($this->id, $this->phone, $phone));

        $this->phone = $phone;
    }

    public function confirm(): void
    {
        if (!$this->status->isUnconfirmed()) {
            throw new DomainException('Unable to activate user.');
        }

        $this->status = Status::active();
    }

    /**
     * @param Status $status
     */
    public function changeStatus(Status $status): void
    {
//        $this->recordEvent(new EventChangeStatus($this->id, $this->status, $status));

        $this->status = $status;
    }

    /**
     * @param PasswordHash $passwordHash
     */
    public function changePassword(PasswordHash $passwordHash): void
    {
        if ($this->passwordHash->isEqual($passwordHash)) {
            return;
        }

        $this->passwordHash = $passwordHash;
    }

    /**
     * @param Company $company
     */
    public function changeCompany(Company $company): void
    {
        if ($this->company->isEqual($company)) {
            return;
        }

        $this->company = $company;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new DomainException('User is already active.');
        }

        $this->changeStatus(Status::active());
    }

    public function block(): void
    {
        if ($this->isBlocked()) {
            throw new DomainException('User is already blocked.');
        }

        $this->changeStatus(Status::block());
    }

    /**
     * @param ResetToken        $token
     * @param DateTimeImmutable $date
     */
    public function requestPasswordReset(ResetToken $token, DateTimeImmutable $date): void
    {
        if (!$this->isActive()) {
            throw new DomainException('User is not active.');
        }

        if (!$this->email) {
            throw new DomainException('Email is not specified.');
        }

        if ($this->resetToken && !$this->resetToken->isExpiredTo($date)) {
            throw new DomainException('Resetting is already requested.');
        }

        $this->resetToken = $token;
    }

    /**
     * @param DateTimeImmutable $date
     * @param PasswordHash      $hash
     */
    public function passwordReset(DateTimeImmutable $date, PasswordHash $hash): void
    {
        if (!$this->resetToken) {
            throw new DomainException('Resetting is not requested.');
        }

        if ($this->resetToken->isExpiredTo($date)) {
            throw new DomainException('Reset token is expired.');
        }

        $this->passwordHash = $hash;
        $this->resetToken = null;
    }

    /**
     * @param Role $role
     */
    public function changeRole(Role $role): void
    {
        if ($this->role->isEqual($role)) {
            return;
        }

        $this->role = $role;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isEqual(User $user): bool
    {
        return $this->getId()->getValue() === $user->getId()->getValue();
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
     * @return Photo
     */
    public function getPhoto(): Photo
    {
        return $this->photo;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @return PasswordHash
     */
    public function getPasswordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }

    /**
     * @return ResetToken|null
     */
    public function getResetToken(): ?ResetToken
    {
        return $this->resetToken;
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
    public function getCreator(): Creator
    {
        return $this->user;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @ORM\PostLoad()
     */
    public function checkEmbeds(): void
    {
        if ($this->resetToken->isEmpty()) {
            $this->resetToken = null;
        }
    }
}
