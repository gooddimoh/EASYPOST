<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\LinkSocial;

use App\Model\User\Entity\Social\Fields\{SocialId, Type, User};
use App\Model\User\Entity\Social\Social;
use App\Model\User\Entity\User\Fields\Email;
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\User\Repositories\Social\SocialRepositoryInterface;
use App\Model\User\Repositories\User\UserRepositoryInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\User\UseCase\User\LinkSocial
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
     * @return Social|null
     * @throws Exception
     */
    public function handle(Command $command): ?Social
    {
        $user = $this->userRepository->findByEmail(new Email($command->email));

        if (!$user) {
            return null;
        }

        $social = new Social(
            new User($user->getId()->getValue()),
            new SocialId($command->socialId),
            new Type($command->type),
            new DateTimeImmutable()
        );

        $this->socialRepository->add($social);
        $this->flusher->flush();

        return $social;
    }
}
