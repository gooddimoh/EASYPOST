<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Social;

use App\Infrastructure\Services\UuidGenerator;
use App\Model\User\Entity\Social\Fields\{User, SocialId, Type};
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;

/**
 * Class Social
 *
 * @package App\Model\User\Entity\Social
 *
 * @ORM\Entity
 * @ORM\Table(name="user_user_socials")
 */
class Social
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;

    /**
     * @var User
     * @ORM\Embedded(class="App\Model\User\Entity\Social\Fields\User")
     */
    private User $user;

    /**
     * @var SocialId
     * @ORM\Embedded(class="App\Model\User\Entity\Social\Fields\SocialId")
     */
    private SocialId $socialId;

    /**
     * @var Type
     * @ORM\Embedded(class="App\Model\User\Entity\Social\Fields\Type")
     */
    private Type $type;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @param User              $user
     * @param SocialId          $socialId
     * @param Type              $type
     * @param DateTimeImmutable $date
     *
     * @throws Exception
     */
    public function __construct(
        User              $user,
        SocialId          $socialId,
        Type              $type,
        DateTimeImmutable $date
    ) {
        $this->id = UuidGenerator::generate();
        $this->user = $user;
        $this->socialId = $socialId;
        $this->type = $type;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return SocialId
     */
    public function getSocialId(): SocialId
    {
        return $this->socialId;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
