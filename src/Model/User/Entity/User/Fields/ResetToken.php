<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;
use DateTimeImmutable;

/**
 * Class ResetToken
 * @package App\Model\User\Entity\User\Fields
 * @ORM\Embeddable
 */
class ResetToken
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $token;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private DateTimeImmutable $expires;

    /**
     * ResetToken constructor.
     * @param string $token
     * @param DateTimeImmutable $expires
     */
    public function __construct(string $token, DateTimeImmutable $expires)
    {
        Assert::notEmpty($token);

        $this->token = $token;
        $this->expires = $expires;
    }

    /**
     * @param \DateTimeImmutable $date
     * @return bool
     */
    public function isExpiredTo(\DateTimeImmutable $date): bool
    {
        return $this->expires <= $date;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @internal for postLoad callback
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->token);
    }
}
