<?php

declare(strict_types=1);

namespace App\Model\Stripe\Entity\Customer\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class BankAccountToken
 *
 * @package App\Model\Stripe\Entity\Customer\Fields
 * @ORM\Embeddable
 */
class BankAccountToken
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $value;

    /**
     * BankAccountToken constructor.
     *
     * @param string|null $value
     */
    public function __construct(?string $value = null)
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
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
