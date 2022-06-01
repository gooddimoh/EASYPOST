<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Create;

use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Fields\{
    Company,
    Creator,
    Name,
    Id,
    PasswordHash,
    Phone,
    Photo,
    Status,
    Role,
    Email
};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Repositories\User\UserRepositoryInterface;
use App\Model\User\Service\NewUserSender;
use App\Model\User\Service\PasswordGenerator;
use App\Model\User\Service\PasswordHasher;
use DomainException;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\User\UseCase\User\Create
 */
class Handler
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var PasswordHasher
     */
    private PasswordHasher $hasher;

    /**
     * @var PasswordGenerator
     */
    private PasswordGenerator $generator;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @var NewUserSender
     */
    private NewUserSender $sender;

    /**
     * Handler constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param PasswordHasher          $hasher
     * @param PasswordGenerator       $generator
     * @param NewUserSender           $sender
     * @param FlusherInterface        $flusher
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordHasher          $hasher,
        PasswordGenerator       $generator,
        NewUserSender           $sender,
        FlusherInterface        $flusher
    ) {
        $this->flusher = $flusher;
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->generator = $generator;
        $this->sender = $sender;
    }

    /**
     * @param Command $command
     *
     * @return User
     * @throws Exception
     */
    public function handle(Command $command): User
    {
        $email = new Email($command->email);

        if ($this->userRepository->hasByEmail($email)) {
            throw new DomainException('User with this email already exists.');
        }

        $password = $this->generator->generate();

        $user = new User(
            Id::next(),
            new Name($command->name),
            new PasswordHash($this->hasher->hash($password)),
            new Company($command->company),
            $email,
            new Phone($command->phoneCode, $command->number),
            new Photo($command->photo),
            new Role($command->role),
            new Creator($command->modifiedId),
            new DateTimeImmutable(),
            Status::unconfirmed()
        );

        $this->sender->send($email, $password);

        $this->userRepository->add($user);
        $this->flusher->flush($user);

        return $user;
    }
}
