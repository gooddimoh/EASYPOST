<?php

namespace App\Security;

use Anyx\LoginGateBundle\Service\BruteForceChecker;
use App\Model\User\Service\PasswordHasher;
use App\Services\Auth\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Class LoginFormAuthenticator
 * @package App\Security
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /**
     * @var BruteForceChecker
     */
    private BruteForceChecker $bruteForceChecker;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * @var CsrfTokenManagerInterface
     */
    private CsrfTokenManagerInterface $csrfTokenManager;

    /**
     * @var PasswordHasher
     */
    private PasswordHasher $hasher;

    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * LoginFormAuthenticator constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param BruteForceChecker $bruteForceChecker
     * @param AuthService $authService
     * @param PasswordHasher $hasher
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        BruteForceChecker $bruteForceChecker,
        AuthService $authService,
        PasswordHasher $hasher
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->hasher = $hasher;
        $this->bruteForceChecker = $bruteForceChecker;
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getCredentials(Request $request): array
    {
        if (!$this->bruteForceChecker->canLogin($request)) {
            throw new CredentialsExpiredException('Brute');
        }

        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
            'session_id' => $request->request->get('session_id'),
        ];

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException('');
        }

        $user = $userProvider->loadUserByUsername($credentials['email']);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Username could not be found.');
        }

        return $user;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $valid = $this->hasher->validate($credentials['password'], $user->getPassword());

        if ($valid && $credentials['session_id']) {
            $this->authService->deleteSession($credentials['session_id']);
        }

        return $valid;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return JsonResponse|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new JsonResponse($this->authService->getResponse());
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse($this->authService->getResponse($exception));
    }

    /**
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('app_login');
    }
}
