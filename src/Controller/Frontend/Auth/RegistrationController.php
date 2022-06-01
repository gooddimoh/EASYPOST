<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Auth;

use App\Model\User\UseCase\User\Create\Command as UserCommand;
use App\ModelServices\FirstRegistrationHandler;
use App\Services\Auth\ManualLoginUserService;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/registration", name="auth.registration")
 *
 * Class RegistrationController
 *
 * @package App\Controller\Frontend\Auth
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("", name=".index", methods={"POST"})
     *
     * @param Request                  $request
     * @param LoggerInterface          $logger
     * @param ManualLoginUserService   $manualLoginUserService
     * @param UserCommand              $command
     * @param FirstRegistrationHandler $registrationHandler
     *
     * @return Response
     * @throws Exception
     * @throws \Exception
     */
    public function registration(
        Request                  $request,
        LoggerInterface          $logger,
        ManualLoginUserService   $manualLoginUserService,
        UserCommand              $command,
        FirstRegistrationHandler $registrationHandler
    ): Response {
        $response = new RedirectResponse($this->generateUrl('dashboard.index'));

        try {
            $user = $registrationHandler->handle($command);
        } catch (\DomainException $exception) {
            $logger->info(
                sprintf(
                    'User with email - "%s" already exists for registration and was redirected to the dashboard.',
                    $command->email
                )
            );

            return $response;
        }

        $manualLoginUserService->login($request, $user->getEmail()->getValue());

        return $response;
    }
}
