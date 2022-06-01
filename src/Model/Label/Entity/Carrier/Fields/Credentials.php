<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Credentials
 *
 * @package App\Model\Label\Entity\Carrier\Fields
 * @ORM\Embeddable
 */
class Credentials
{
    /**
     * @var array
     * @ORM\Column(type="json", nullable=false)
     */
    private array $value;

    /**
     * Credentials constructor.
     *
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->value = $credentials;
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * @param self $value
     *
     * @return bool
     */
    public function isEqual(self $value): bool
    {
        return count(array_diff_assoc($value->getValue(), $this->value)) === 0;
    }
}
