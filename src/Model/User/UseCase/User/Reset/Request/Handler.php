<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Reset\Request;


use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Entity\User\Fields\Email;
use App\Model\User\Repositories\User\UserRepositoryInterface;
use App\Model\User\Service\ResetTokenizer;
use App\Model\User\Service\ResetTokenSender;

/**
 * Class Handler
 * @package App\Model\User\UseCase\User\Reset\Request
 */
class Handler
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $users;

    /**
     * @var ResetTokenizer
     */
    private ResetTokenizer $tokenizer;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @var ResetTokenSender
     */
    private ResetTokenSender $sender;

    /**
     * Handler constructor.
     * @param UserRepositoryInterface $users
     * @param ResetTokenizer $tokenizer
     * @param FlusherInterface $flusher
     * @param ResetTokenSender $sender
     */
    public function __construct(
        UserRepositoryInterface $users,
        ResetTokenizer $tokenizer,
        FlusherInterface $flusher,
        ResetTokenSender $sender
    )
    {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    /**
     * @param Command $command
     * @throws \Exception
     */
    public function handle(Command $command): void
    {
        $user = $this->users->getByEmail(new Email($command->email));

        $user->requestPasswordReset(
            $this->tokenizer->generate(),
            new \DateTimeImmutable()
        );

        $this->sender->send($user->getEmail(), $user->getResetToken());

        $this->flusher->flush();
    }
}
