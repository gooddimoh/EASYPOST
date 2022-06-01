<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Package\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permissions
 *
 * @package App\Model\Company\Entity\Package\Fields
 * @ORM\Embeddable
 */
class Permissions
{
    /**
     * @var array
     * @ORM\Column(type="json", nullable=false)
     */
    private array $value;

    /**
     * Permissions constructor.
     *
     * @param array $value
     */
    public function __construct(array $value)
    {
        $this->value = $value;
    }

    /**
     * @param self $permissions
     *
     * @return bool
     */
    public function isEqual(self $permissions): bool
    {
        return $this->value === $permissions->getValue();
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
