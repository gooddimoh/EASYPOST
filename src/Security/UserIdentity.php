<?php

declare(strict_types=1);

namespace App\Security;

use App\Infrastructure\Enums\Model\Company\TypeEnum;
use App\Infrastructure\Enums\Model\User\StatusEnum;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\LegacyPasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserIdentity
 *
 * @package App\Security
 */
class UserIdentity implements UserInterface, EquatableInterface, PasswordAuthenticatedUserInterface, LegacyPasswordAuthenticatedUserInterface
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var int
     */
    private int $status;

    /**
     * @var string
     */
    private string $role;

    /**
     * @var string
     */
    private string $company;

    /**
     * @var string|null
     */
    private ?string $companyName;

    /**
     * @var string
     */
    private string $fullName;

    /**
     * @var string
     */
    private string $photo;

    /**
     * @var int
     */
    private int $companyType;

    /**
     * @var string|null
     */
    private ?string $activePackage;

    /**
     * @var array|null
     */
    private ?array $permission;

    /**
     * UserIdentity constructor.
     *
     * @param string      $id
     * @param string      $username
     * @param string      $password
     * @param int         $status
     * @param string      $role
     * @param string      $company
     * @param string|null $companyName
     * @param string      $fullName
     * @param string      $photo
     * @param int         $companyType
     * @param string|null $activePackage
     * @param array|null  $permission
     */
    public function __construct(
        string  $id,
        string  $username,
        string  $password,
        int     $status,
        string  $role,
        string  $company,
        ?string $companyName,
        string  $fullName,
        string  $photo,
        int     $companyType,
        ?string $activePackage,
        ?array  $permission
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
        $this->role = $role;
        $this->company = $company;
        $this->companyName = $companyName;
        $this->fullName = $fullName;
        $this->photo = $photo;
        $this->companyType = $companyType;
        $this->activePackage = $activePackage;
        $this->permission = $permission;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @return string|null
     */
    public function getActivePackage(): ?string
    {
        return $this->activePackage;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->status === StatusEnum::BLOCK;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {

    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return int
     */
    public function getCompanyType(): int
    {
        return $this->companyType;
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo ? '/storage/' . $this->photo : '';
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        if ($user->status === StatusEnum::BLOCK) {
            return false;
        }

        return
            $this->id === $user->id &&
            $this->password === $user->password &&
            $this->company === $user->company &&
            $this->role === $user->role;
    }

    /**
     * @return array|string[]
     */
    public function getPermission(): array
    {
        return array_merge(
            [$this->role],
            ($this->permission ?? []),
            [TypeEnum::getCompanyTypeName($this->companyType)]
        );
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->getPermission();
    }
}
