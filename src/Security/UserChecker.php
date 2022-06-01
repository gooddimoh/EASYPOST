<?php

declare(strict_types=1);

namespace App\Security;

use App\Services\Session\SessionService;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserChecker
 * @package App\Security
 */
class UserChecker implements UserCheckerInterface
{
    /**
     * @var SessionService
     */
    private SessionService $sessionService;

    /**
     * UserChecker constructor.
     * @param SessionService $sessionService
     */
    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * @param UserInterface $identity
     */
    public function checkPreAuth(UserInterface $identity): void
    {
        if (!$identity instanceof UserIdentity) {
            return;
        }

        if ($identity->isBlocked()) {
            $exception = new DisabledException('User account is disabled.');
            $exception->setUser($identity);
            throw $exception;
        }
    }

    /**
     * @param UserInterface $identity
     */
    public function checkPostAuth(UserInterface $identity): void
    {
        if (!$identity instanceof UserIdentity) {
            return;
        }

//        if (!$this->sessionService->isUserHaveAvailableSessions($identity->getId())) {
//            $exception = new LockedException('You have 2 active sessions');
//            $exception->setUser($identity);
//            throw $exception;
//        }
    }
}
