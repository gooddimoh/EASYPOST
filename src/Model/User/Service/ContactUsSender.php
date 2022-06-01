<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use Twig\Environment;
use Swift_Mailer;
use Swift_Message;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ContactUsSender
 *
 * @package App\Model\User\Service
 */
class ContactUsSender
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
     * @var array
     */
    private array $adminEmails;

    /**
     * ContactUsSender constructor.
     *
     * @param Swift_Mailer $mailer
     * @param Environment  $twig
     * @param array        $adminEmails
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig, array $adminEmails)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->adminEmails = $adminEmails;
    }

    /**
     * @param string $fullName
     * @param string $email
     * @param string $message
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function send(string $fullName, string $email, string $message): void
    {
        $message = (new Swift_Message('New message from user'))
            ->setTo($this->adminEmails)
            ->setBody(
                $this->twig->render('mail/contact-us/message.html.twig', [
                    'fullName' => $fullName,
                    'email' => $email,
                    'message' => $message,
                ]),
                'text/html'
            );

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
