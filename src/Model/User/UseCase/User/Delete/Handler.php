<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Delete;

use App\Model\User\Entity\User\Fields\Status;
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Entity\User\Fields\Id;
use App\Model\User\Repositories\Social\SocialRepositoryInterface;
use App\Model\User\Repositories\User\UserRepositoryInterface;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\User\UseCase\User\Delete
 */
class Handler
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var SocialRepositoryInterface
     */
    private SocialRepositoryInterface $socialRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param UserRepositoryInterface   $userRepository
     * @param SocialRepositoryInterface $socialRepository
     * @param FlusherInterface          $flusher
     */
    public function __construct(
        UserRepositoryInterface   $userRepository,
        SocialRepositoryInterface $socialRepository,
        FlusherInterface          $flusher
    ) {
        $this->flusher = $flusher;
        $this->userRepository = $userRepository;
        $this->socialRepository = $socialRepository;
    }

    /**
     * @param Command $command
     *
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        $user = $this->userRepository->get(new Id($command->id));
        $user->changeStatus(Status::block());

        $this->userRepository->add($user);

        $this->flusher->flush($user);

        $this->socialRepository->delete($user->getId()->getValue());
    }
}
