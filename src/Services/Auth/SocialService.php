<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Infrastructure\Enums\Model\User\SocialEnum;
use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\ReadModels\User\Social\SocialFetcher;
use App\Services\Auth\DTO\SocialUser;
use Doctrine\DBAL\Exception;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;

class SocialService
{
    /**
     * @var ClientRegistry
     */
    private ClientRegistry $clientRegistry;

    /**
     * @var SocialFetcher
     */
    private SocialFetcher $fetcher;

    /**
     * @var SocialUser
     */
    private SocialUser $socialUser;

    /**
     * @param ClientRegistry $clientRegistry
     * @param SocialFetcher  $fetcher
     * @param SocialUser     $socialUser
     */
    public function __construct(
        ClientRegistry $clientRegistry,
        SocialFetcher  $fetcher,
        SocialUser     $socialUser
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->fetcher = $fetcher;
        $this->socialUser = $socialUser;
    }

    /**
     * @param string $socialId
     * @param int    $type
     *
     * @return array
     * @throws Exception
     */
    public function findBySocialId(string $socialId, int $type): array
    {
        return $this->fetcher->findBySocialId($socialId, $type);
    }

    /**
     * @param int $socialType
     *
     * @return SocialUser
     */
    public function getUserData(int $socialType): SocialUser
    {
        if (!in_array($socialType, SocialEnum::getAll(), true)) {
            throw new InvalidRequestParameter('Unknown social auth type.');
        }

        $client = $this->clientRegistry->getClient(SocialEnum::STRING_PRESENTATION[$socialType]);
        $user = $client->fetchUser();

        $this->socialUser->id = $user->getId();
        $this->socialUser->firstName = $user->getFirstName() ?: null;
        $this->socialUser->lastName = $user->getLastName() ?: null;
        $this->socialUser->email = $user->getEmail();
        $this->socialUser->type = $socialType;

        return $this->socialUser;
    }
}
