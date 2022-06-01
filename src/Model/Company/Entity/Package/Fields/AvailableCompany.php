<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Package\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class AvailableCompany
 *
 * @package App\Model\Company\Entity\Package\Fields
 * @ORM\Embeddable
 */
class AvailableCompany
{
    /**
     * @var string|null
     * @ORM\Column(type="guid", nullable=true)
     */
    private ?string $value;

    /**
     * AvailableCompany constructor.
     *
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        Assert::nullOrUuid($value);

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
