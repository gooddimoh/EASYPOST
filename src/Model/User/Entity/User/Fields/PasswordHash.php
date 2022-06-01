<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Name
 * @package App\Model\User\Entity\User\Fields
 * @ORM\Embeddable
 */
class PasswordHash
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * PasswordHash constructor.
     * @param string $passwordHash
     */
    public function __construct(string $passwordHash)
    {
        $this->value = $passwordHash;
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
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
