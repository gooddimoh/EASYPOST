<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Auth\Social;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Model\User\UseCase\User\Create\Command as UserCommand;
use App\Model\User\UseCase\User\LinkSocial\Command as LinkSocialCommand;
use App\Model\User\UseCase\User\LinkSocial\Handler as LinkSocialHandler;
use App\ModelServices\FirstRegistrationHandler;
use App\Services\Auth\ManualLoginUserService;
use App\Services\Auth\SocialService;
use Doctrine\DBAL\Exception;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/auth/socials/connect", name="auth.social.connect")
 */
class SocialController extends AbstractController
{
    /**
     * @var ManualLoginUserService
     */
    private ManualLoginUserService $manualLoginUserService;

    /**
     * @param ManualLoginUserService $manualLoginUserService
     */
    public function __construct(ManualLoginUserService $manualLoginUserService)
    {
        $this->manualLoginUserService = $manualLoginUserService;
    }

    /**
     * @Route("/facebook", name=".facebook", methods={"GET"})
     *
     * @param ClientRegistry $clientRegistry
     *
     * @return Response
     */
    public function facebook(ClientRegistry $clientRegistry): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        return $clientRegistry
            ->getClient('facebook')
            ->redirect([
                'public_profile',
                'email'
            ]);
    }

    /**
     * @Route("/google", name=".google", methods={"GET"})
     *
     * @param ClientRegistry $clientRegistry
     *
     * @return Response
     */
    public function google(ClientRegistry $clientRegistry): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        return $clientRegistry
            ->getClient('google')
            ->redirect([
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile'
            ]);
    }

    /**
     * @Route("/check", name=".check")
     *
     * @param Request                  $request
     * @param LinkSocialCommand        $linkSocialCommand
     * @param LinkSocialHandler        $linkSocialHandler
     * @param UserCommand              $userCommand
     * @param FirstRegistrationHandler $registrationHandler
     * @param SocialService            $socialService
     *
     * @return Response
     * @throws Exception
     * @throws \Exception
     */
    public function check(
        Request                  $request,
        LinkSocialCommand        $linkSocialCommand,
        LinkSocialHandler        $linkSocialHandler,
        UserCommand              $userCommand,
        FirstRegistrationHandler $registrationHandler,
        SocialService            $socialService
    ): Response {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        $type = $request->get('type');

        if (!$type || !is_numeric($type)) {
            throw new InvalidRequestParameter('Social auth type is required.');
        }

        $userData = $socialService->getUserData((int) $type);
        $socialData = $socialService->findBySocialId($userData->id, $userData->type);

        if ($socialData) {
            return $this->autoLoginResponse($request, $userData->email);
        }

        $linkSocialCommand->email = $userData->email;
        $linkSocialCommand->socialId = $userData->id;
        $linkSocialCommand->type = $userData->type;

        $social = $linkSocialHandler->handle($linkSocialCommand);

        if ($social) {
            return $this->autoLoginResponse($request, $userData->email);
        }

        $userCommand->name = $userData->firstName && $userData->lastName ? sprintf(
            '%s %s',
            $userData->firstName,
            $userData->lastName
        ) : null;
        $userCommand->email = $userData->email;
        $user = $registrationHandler->handle($userCommand);

        return $this->autoLoginResponse($request, $user->getEmail()->getValue());
    }

    /**
     * @param Request $request
     * @param string  $email
     *
     * @return Response
     * @throws Exception
     */
    private function autoLoginResponse(Request $request, string $email): Response
    {
        $this->manualLoginUserService->login($request, $email);

        return new RedirectResponse($this->generateUrl('label.index'));
    }
}
