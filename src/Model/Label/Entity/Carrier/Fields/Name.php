<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Name
 *
 * @package App\Model\Label\Entity\Carrier\Fields
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
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param self $name
     *
     * @return bool
     */
    public function isEqual(self $name): bool
    {
        return $this->value === $name->getValue();
    }
}
