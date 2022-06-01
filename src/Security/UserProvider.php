<?php

declare(strict_types=1);

namespace App\Security;

use App\ReadModels\User\AuthView;
use App\ReadModels\User\{UserFetcher};
use Symfony\Component\Security\Core\Exception\{
    UnsupportedUserException,
    UserNotFoundException
};
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserProvider
 * @package App\Security
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var UserFetcher
     */
    private UserFetcher $users;

    /**
     * UserProvider constructor.
     * @param UserFetcher $users
     */
    public function __construct(UserFetcher $users)
    {
        $this->users = $users;
    }

    /**
     * @param string $username
     * @return UserInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function loadUserByUsername($username): UserInterface
    {
        $user = $this->loadUser($username);

        return self::identityByUser($user);
    }

    /**
     * @param string $username
     * @return UserInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function loadUserByIdentifier($username): UserInterface
    {
        return $this->loadUserByUsername($username);
    }

    /**
     * @param UserInterface $identity
     * @return UserInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function refreshUser(UserInterface $identity): UserInterface
    {
        if (!$identity instanceof UserIdentity) {
            throw new UnsupportedUserException('Invalid user class ' . \get_class($identity));
        }

        $user = $this->loadUser($identity->getUsername());

        return self::identityByUser($user);
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return $class === UserIdentity::class;
    }

    /**
     * @param string $email
     * @return AuthView
     * @throws \Doctrine\DBAL\Exception
     */
    private function loadUser(string $email): AuthView
    {
        $userView = $this->users->findForAuthByEmail($email);

        if (!$userView) {
            throw new UserNotFoundException('Invalid user');
        }

        return $userView;
    }

    /**
     * @param AuthView $user
     * @return UserIdentity
     */
    private static function identityByUser(AuthView $user): UserIdentity
    {
        return new UserIdentity(
            $user->id,
            $user->email,
            $user->password_hash,
            $user->status,
            $user->role,
            $user->company,
            $user->company_name,
            $user->name,
            $user->photo,
            $user->company_type,
            $user->active_package,
            $user->permission,
        );
    }
}
