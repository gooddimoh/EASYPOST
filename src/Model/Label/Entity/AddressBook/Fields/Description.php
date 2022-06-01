<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\AddressBook\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Description
 * @package App\Model\Label\Entity\AddressBook\Fields
 * @ORM\Embeddable
 */
class Description
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $value;

    /**
     * Description constructor.
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value ? $value : null;
    }

    /**
     * @param self $name
     * @return bool
     */
    public function isEqual(self $name): bool
    {
        return $this->value === $name->getValue();
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
