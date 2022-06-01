<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Confirm;

use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Fields\{Id, Name, Phone};
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
        $user->changePhone(new Phone($command->code, $command->phone));
        $user->confirm();

        $this->userRepository->add($user);
        $this->flusher->flush($user);

        return $user;
    }
}
