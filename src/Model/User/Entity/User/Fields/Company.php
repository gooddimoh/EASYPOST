<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Company
 * @package App\Model\User\Entity\User\Fields
 * @ORM\Embeddable
 */
class Company
{
    /**
     * @var string
     * @ORM\Column(type="guid", name="company_id", nullable=true)
     */
    private ?string $value;

    /**
     * Company constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param self $photo
     * @return bool
     */
    public function isEqual(self $photo): bool
    {
        return $this->getValue() === $photo->getValue();
    }
}
