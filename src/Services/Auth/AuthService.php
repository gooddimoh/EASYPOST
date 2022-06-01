<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Security\SecurityModified;
use App\Security\UserIdentity;
use App\Services\Session\SessionService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Throwable;

/**
 * Class AuthService
 * @package App\Services\Auth
 */
class AuthService
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * @var SessionService
     */
    private SessionService $sessionService;

    /**
     * @var SecurityModified
     */
    private SecurityModified $security;

    /**
     * AuthService constructor.
     * @param SessionService $sessionService
     * @param UrlGeneratorInterface $urlGenerator
     * @param SecurityModified $security
     */
    public function __construct(
        SessionService $sessionService,
        UrlGeneratorInterface $urlGenerator,
        SecurityModified $security
    )
    {
        $this->sessionService = $sessionService;
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $sessionId
     * @return bool
     */
    public function deleteSession(string $sessionId): bool
    {
        return $this->sessionService->deleteSession($sessionId);
    }

    /**
     * @param Throwable|null $exception
     * @return array
     */
    public function getResponse(?Throwable $exception = null): array
    {
        $errorMessage = '';
        $redirect = '';
        $data = [];

        if ($exception instanceof LockedException) {
            $errorMessage = $exception->getMessage();

            /**
             * @var UserIdentity
             */
            $user = $exception->getUser();
            $data = $this->sessionService->getUserSessions($user->getId(), true);
        } elseif ($exception instanceof CredentialsExpiredException) {
            $errorMessage = 'Auth request limit';
        } elseif ($exception) {
            $errorMessage = 'Authentication failed';
        } elseif ($user = $this->security->getUser()) {
            $redirectTo = 'label.index';
            $redirect = $this->urlGenerator->generate($redirectTo);
        }

        return [
            'status' => !$exception,
            'message' => [
                'error' => $errorMessage,
                'data' => $data,
                'redirect' => $redirect
            ]
        ];
    }
}
