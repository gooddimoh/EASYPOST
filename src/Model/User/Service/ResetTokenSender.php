<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Fields\Email;
use App\Model\User\Entity\User\Fields\ResetToken;
use Twig\Environment;
use Swift_Mailer;

/**
 * Class ResetTokenSender
 * @package App\Model\User\Service
 */
class ResetTokenSender
{
    /**
     * @var Swift_Mailer
     */
    private Swift_Mailer $mailer;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * ResetTokenSender constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param Email $email
     * @param ResetToken $token
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function send(Email $email, ResetToken $token): void
    {
        $message = (new \Swift_Message('Password resetting'))
            ->setTo($email->getValue())
            ->setBody($this->twig->render('mail/user/reset.html.twig', [
                'token' => $token->getToken()
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
