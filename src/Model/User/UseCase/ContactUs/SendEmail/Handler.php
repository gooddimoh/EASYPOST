<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ContactUs\SendEmail;

use App\Model\User\Service\ContactUsSender;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Handler
 *
 * @package App\Model\User\UseCase\ContactUs\SendEmail
 */
class Handler
{
    /**
     * @var ContactUsSender
     */
    private ContactUsSender $sender;

    /**
     * Handler constructor.
     *
     * @param ContactUsSender $sender
     */
    public function __construct(ContactUsSender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param Command $command
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handle(Command $command): void
    {
        $this->sender->send($command->fullName, $command->email, $command->message);
    }
}
