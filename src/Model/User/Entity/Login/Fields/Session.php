<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Login\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Session
 * @package App\Model\User\Entity\Login\Fields
 * @ORM\Embeddable
 */
class Session
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private ?string $value;

    /**
     * Session constructor.
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        Assert::maxLength($value, 40, 'Session Id must not be longer than 40 characters');

        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
