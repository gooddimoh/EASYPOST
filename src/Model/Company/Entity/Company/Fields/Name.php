<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Name
 *
 * @package App\Model\Company\Entity\Company\Fields
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $value;

    /**
     * Name constructor.
     *
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        $this->value = $value;
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

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
