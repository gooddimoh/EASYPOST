<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Security\UserProvider;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ManualLoginUserService
{
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;

    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;

    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @param UserProvider             $userProvider
     * @param EventDispatcherInterface $eventDispatcher
     * @param TokenStorageInterface    $tokenStorage
     * @param SessionInterface         $session
     */
    public function __construct(
        UserProvider             $userProvider,
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface    $tokenStorage,
        SessionInterface         $session
    ) {
        $this->userProvider = $userProvider;
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * @param Request $request
     * @param string  $email
     *
     * @throws Exception
     */
    public function login(Request $request, string $email): void
    {
        $userIdentity = $this->userProvider->loadUserByUsername($email);

        $this->session->set(
            Security::LAST_USERNAME,
            $userIdentity->getUsername()
        );

        $token = $this->refreshUserIdentity($userIdentity);
        $this->session->set('_security_main', serialize($token));

        $event = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch($event, "security.interactive_login");
    }

    /**
     * @param UserInterface $userIdentity
     *
     * @return TokenInterface
     */
    public function refreshUserIdentity(UserInterface $userIdentity): TokenInterface
    {
        $token = new UsernamePasswordToken(
            $userIdentity,
            $userIdentity->getPassword(),
            "main",
            $userIdentity->getRoles()
        );

        $this->tokenStorage->setToken($token);

        return $token;
    }
}
