<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Update;

use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Fields\{Id, Name, Photo, Role};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Repositories\User\UserRepositoryInterface;

class Handler
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param FlusherInterface        $flusher
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        FlusherInterface        $flusher
    ) {
        $this->flusher = $flusher;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Command $command
     *
     * @return User
     * @throws \Exception
     */
    public function handle(Command $command): User
    {
        $user = $this->userRepository->get(new Id($command->id));

        $user->changeName(new Name($command->name));
        $user->changePhoto(new Photo($command->photo));
        $user->changeRole(new Role($command->role));

        $this->userRepository->add($user);
        $this->flusher->flush($user);

        return $user;
    }
}
