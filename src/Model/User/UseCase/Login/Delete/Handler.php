<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Login\Delete;

use App\Model\User\Entity\Login\Fields\User;
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Repositories\Login\LoginRepositoryInterface;

/**
 * Class Handler
 * @package App\Model\User\UseCase\Login\Create
 */
class Handler
{
    /**
     * @var LoginRepositoryInterface
     */
    private LoginRepositoryInterface $loginRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     * @param LoginRepositoryInterface $loginRepository
     * @param FlusherInterface $flusher
     */
    public function __construct(
        LoginRepositoryInterface $loginRepository,
        FlusherInterface $flusher
    )
    {
        $this->flusher = $flusher;
        $this->loginRepository = $loginRepository;
    }

    /**
     * @param Command $command
     * @return string
     */
    public function handle(Command $command): string
    {
        $this->loginRepository->delete(new User($command->id));
        $this->flusher->flush();

        return $command->id;
    }
}
