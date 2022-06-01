<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\AddressBook\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Name
 * @package App\Model\Label\Entity\AddressBook\Fields
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * Name constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
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
