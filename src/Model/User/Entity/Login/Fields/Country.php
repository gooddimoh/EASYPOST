<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Login\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Country
 * @package App\Model\User\Entity\Login\Fields
 * @ORM\Embeddable
 */
class Country
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $value;

    /**
     * Country constructor.
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        Assert::maxLength($value, 255, 'Country name must not be longer than 255 characters');

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
