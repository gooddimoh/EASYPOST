<?php

declare(strict_types=1);

namespace App\Controller\Api\ContactUs;

use App\Model\User\UseCase\ContactUs\SendEmail\Command as SendEmailCommand;
use App\Model\User\UseCase\ContactUs\SendEmail\Handler as SendEmailHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @Route("/contact", name="contact")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/send-email", name=".send-email", methods={"POST"})
     *
     * @param SendEmailCommand $command
     * @param SendEmailHandler $handler
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendEmail(
        SendEmailCommand $command,
        SendEmailHandler $handler
    ): Response {
        $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => []
            ]
        );
    }
}
