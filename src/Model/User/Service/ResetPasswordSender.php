<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Fields\Email;
use App\Model\User\Entity\User\Fields\PasswordHash;
use Twig\Environment;
use Swift_Mailer;

/**
 * Class ResetPasswordSender
 * @package App\Model\User\Service
 */
class ResetPasswordSender
{
    /**
     * @var Swift_Mailer
     */
    private Swift_Mailer$mailer;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * ResetPasswordSender constructor.
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
     * @param PasswordHash $password
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function send(Email $email, PasswordHash $password): void
    {
        $message = (new \Swift_Message('Password is changed'))
            ->setTo($email->getValue())
            ->setBody($this->twig->render('mail/user/reset-password.html.twig', [
                'password' => $password->getValue()
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
