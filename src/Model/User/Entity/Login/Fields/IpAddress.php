<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Login\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class IpAddress
 * @package App\Model\User\Entity\Login\Fields
 * @ORM\Embeddable
 */
class IpAddress
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private ?string $value;

    /**
     * IpAddress constructor.
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        Assert::maxLength($value, 45, 'Ip address must not be longer than 45 characters');

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
