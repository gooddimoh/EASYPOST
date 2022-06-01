<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Transaction\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Description
 * @package App\Model\Company\Entity\Transaction\Fields
 * @ORM\Embeddable
 */
class Description
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * Description constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
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
