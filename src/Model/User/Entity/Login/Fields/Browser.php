<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Login\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Browser
 * @package App\Model\User\Entity\Login\Fields
 * @ORM\Embeddable
 */
class Browser
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $value;

    /**
     * Browser constructor.
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        Assert::maxLength($value, 30, 'Browser name must not be longer than 30 characters');

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
