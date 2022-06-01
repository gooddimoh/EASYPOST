<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Fields\Email;
use Twig\Environment;
use Swift_Mailer;
use Swift_Message;

/**
 * Class NewUserSender
 * @package App\Model\User\Service
 */
class NewUserSender
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
     * NewUserSender constructor.
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
     * @param string $password
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function send(Email $email, string $password): void
    {
        $message = (new Swift_Message('Sign Up Confirmation'))
            ->setTo($email->getValue())
            ->setBody($this->twig->render('mail/user/signup.html.twig', [
                'email' => $email->getValue(),
                'password' => $password,
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
