<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Fields;

use App\Infrastructure\Enums\Model\User\RoleEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Role
 * @package App\Model\User\Entity\User\Fields
 * @ORM\Embeddable
 */
class Role
{
    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private string $value;

    /**
     * Name constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::oneOf($value, RoleEnum::getAll());

        $this->value = $value;
    }

    /**
     * @param self $name
     * @return bool
     */
    public function isEqual(self $name): bool
    {
        return $this->getValue() === $name->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
