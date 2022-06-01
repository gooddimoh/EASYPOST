<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Reset\Reset;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Entity\User\Fields\PasswordHash;
use App\Model\User\Entity\User\User;
use App\Model\User\Repositories\User\UserRepositoryInterface;
use App\Model\User\Service\PasswordHasher;

/**
 * Class Handler
 * @package App\Model\User\UseCase\User\Reset\Reset
 */
class Handler
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $users;

    /**
     * @var PasswordHasher
     */
    private PasswordHasher $hasher;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     * @param UserRepositoryInterface $users
     * @param PasswordHasher $hasher
     * @param FlusherInterface $flusher
     */
    public function __construct(
        UserRepositoryInterface $users,
        PasswordHasher $hasher,
        FlusherInterface $flusher
    )
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     * @return User
     */
    public function handle(Command $command): User
    {
        if (!$user = $this->users->findByResetToken($command->token)) {
            throw new \DomainException('Incorrect or confirmed token.');
        }

        $user->passwordReset(
            new \DateTimeImmutable(),
            new PasswordHash($this->hasher->hash($command->password))
        );

        $this->users->add($user);
        $this->flusher->flush();

        return $user;
    }
}
