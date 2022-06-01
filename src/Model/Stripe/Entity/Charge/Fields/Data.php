<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Charge\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Data
 *
 * @package App\Model\Stripe\Entity\Charge\Fields
 * @ORM\Embeddable
 */
class Data
{
    /**
     * @var array
     * @ORM\Column(type="json", nullable=false)
     */
    private array $value;

    /**
     * Data constructor.
     *
     * @param array $value
     */
    public function __construct(array $value)
    {
        $this->value = $value;
    }

    /**
     * @param self $value
     *
     * @return bool
     */
    public function isEqual(self $value): bool
    {
        return $this->value === $value->getValue();
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
