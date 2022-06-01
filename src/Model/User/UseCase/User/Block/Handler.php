<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Block;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Entity\User\Fields\Id;
use App\Model\User\Repositories\User\UserRepositoryInterface;

/**
 * Class Handler
 * @package App\Model\User\UseCase\User\Block
 */
class Handler
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $users;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     * @param UserRepositoryInterface $users
     * @param FlusherInterface $flusher
     */
    public function __construct(UserRepositoryInterface $users, FlusherInterface $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     */
    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $user->block();

        $this->users->add($user);

        $this->flusher->flush();
    }
}
