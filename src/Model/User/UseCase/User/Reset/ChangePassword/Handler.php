<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Reset\ChangePassword;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Entity\User\Fields\{Email, PasswordHash};
use App\Model\User\Repositories\User\UserRepositoryInterface;
use App\Model\User\Service\PasswordHasher;
use App\Model\User\Service\ResetPasswordSender;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class Handler
 * @package App\Model\User\UseCase\User\Reset\ChangePassword
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
     * @var ResetPasswordSender
     */
    private ResetPasswordSender $sender;

    /**
     * @var CsrfTokenManagerInterface
     */
    private CsrfTokenManagerInterface $csrfTokenManager;

    /**
     * Handler constructor.
     * @param UserRepositoryInterface $users
     * @param PasswordHasher $hasher
     * @param FlusherInterface $flusher
     * @param ResetPasswordSender $sender
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function __construct(
        UserRepositoryInterface $users,
        PasswordHasher $hasher,
        FlusherInterface $flusher,
        ResetPasswordSender $sender,
        CsrfTokenManagerInterface $csrfTokenManager
    )
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
        $this->sender = $sender;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @param Command $command
     * @throws \Exception
     */
    public function handle(Command $command): void
    {
        $user = $this->users->getByEmail(new Email($command->email));
        $token = new CsrfToken('authenticate', $command->csrfToken);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new \DomainException('Not valid token!');
        }

        if (!$this->hasher->validate($command->oldPassword, $user->getPasswordHash()->getValue())) {
            throw new \DomainException('Not valid old password!');
        }

        $user->changePassword(new PasswordHash($this->hasher->hash($command->password)));
        // $user->changeDate(new \DateTimeImmutable());

        $this->sender->send(new Email($command->email), new PasswordHash($command->password));

        $this->flusher->flush();
    }
}
