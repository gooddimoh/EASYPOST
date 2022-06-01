<?php

declare(strict_types=1);

namespace App\Controller\Api\Auth;

use Anyx\LoginGateBundle\Service\BruteForceChecker;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\User\UseCase\User\Reset;
use App\ReadModels\User\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth", name="auth.reset")
 *
 * Class ResetController
 * @package App\Controller\Api\Auth
 */
class ResetController extends AbstractController
{
    /**
     * @Route("/request", name=".request", methods={"POST"})
     *
     * @param Reset\Request\Command $command
     * @param Reset\Request\Handler $handler
     * @return Response
     * @throws \Exception
     */
    public function forgot(Reset\Request\Command $command, Reset\Request\Handler $handler): Response
    {
        $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => [
                'data' => 'Check your email.',
                'email' => $command->email
            ]
        ]);
    }

    /**
     * @Route("/reset/{token}", name=".reset", methods={"POST"})
     *
     * @param string $token
     * @param Request $request
     * @param BruteForceChecker $bruteForceChecker
     * @param Reset\Reset\Command $command
     * @param Reset\Reset\Handler $handler
     * @param UserFetcher $users
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function reset(
        string $token,
        Request $request,
        BruteForceChecker $bruteForceChecker,
        Reset\Reset\Command $command,
        Reset\Reset\Handler $handler,
        UserFetcher $users
    ): Response
    {
        if (!$users->existsByResetToken($token)) {
            throw new EntityNotFoundException('Incorrect or already confirmed token.');
        }

        $user = $handler->handle($command);

        $bruteForceChecker->getStorage()->clearCountAttempts($request, $user->getEmail()->getValue());

        return $this->json([
            'status' => true,
            'message' => [
                'data' => 'Password is successfully changed.'
            ]
        ]);
    }

    /**
     * @Route("/change-password", name=".change-password", methods={"POST"})
     *
     * @param Reset\ChangePassword\Command $command
     * @param Reset\ChangePassword\Handler $handler
     * @return Response
     * @throws \Exception
     */
    public function changePassword(Reset\ChangePassword\Command $command, Reset\ChangePassword\Handler $handler): Response
    {
        $command->email = $this->getUser()->getUserName();

        $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => [
                'data' => 'Password is successfully changed.'
            ]
        ]);
    }
}
