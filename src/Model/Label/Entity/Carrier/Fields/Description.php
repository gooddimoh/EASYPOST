<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Description
 *
 * @package App\Model\Label\Entity\Carrier\Fields
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
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);

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
     * @param self $value
     *
     * @return bool
     */
    public function isEqual(self $value): bool
    {
        return $this->value === $value->getValue();
    }
}
