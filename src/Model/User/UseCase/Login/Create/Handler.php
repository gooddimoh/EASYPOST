<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Login\Create;

use App\Model\User\Entity\Login\Login;
use App\Model\User\Entity\Login\Fields\{
    City,
    User,
    Country,
    Browser,
    Session,
    IpAddress,
};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Repositories\Login\LoginRepositoryInterface;
use DateTimeImmutable;
use DomainException;

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
     * @return Login
     * @throws \Exception
     */
    public function handle(Command $command): Login
    {
        $userId = new User($command->id);

        if ($this->loginRepository->exist($userId)) {
            throw new DomainException('User is already Login.');
        }

        $login = new Login(
            $userId,
            new Session($command->session),
            new IpAddress($command->ipAddress),
            new Browser($command->browser),
            new Country($command->country),
            new City($command->city),
            new DateTimeImmutable()
        );

        $this->loginRepository->add($login);
        $this->flusher->flush($login);

        return $login;
    }
}
