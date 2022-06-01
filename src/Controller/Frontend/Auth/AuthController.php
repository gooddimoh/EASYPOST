<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Auth;

use App\ReadModels\User\UserFetcher;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AuthController
 *
 * @package App\Controller\Frontend\Auth
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function index(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        return $this->render('/app/auth/login.html.twig');
    }

    /**
     * @Route("/forgot", name="auth.forgot")
     *
     * @return Response
     */
    public function forgot(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        return $this->render('app/auth/reset/forgot.html.twig');
    }

    /**
     * @Route("/auth/wait", name="auth.wait")
     *
     * @return Response
     */
    public function wait(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        return $this->render('app/auth/wait.html.twig');
    }

    /**
     * @Route("/auth/reset/{token}", name="auth.reset", methods={"GET"})
     *
     * @param string      $token
     * @param UserFetcher $users
     *
     * @return Response
     * @throws Exception
     */
    public function reset(string $token, UserFetcher $users): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        $error = '';

        if (!$users->existsByResetToken($token)) {
            $error = 'Incorrect or already confirmed token.';
        }

        return $this->render(
            'app/auth/reset/reset.html.twig',
            [
                'token' => $token,
                'error' => $error
            ]
        );
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): Response
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/change-password", name="auth.changePassword")
     *
     * @return Response
     */
    public function changePassword(): Response
    {
        return $this->render('app/auth/reset/changePassword.html.twig');
    }

    /**
     * @Route("/registration", name="registration", methods={"GET"})
     *
     * @return Response
     */
    public function registration(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        return $this->render('/app/auth/registration.html.twig');
    }
}
