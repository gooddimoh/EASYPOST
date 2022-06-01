<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields\Package\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Weight
 *
 * @package App\Model\Label\Entity\Label\Fields\Package\Fields
 * @ORM\Embeddable
 */
class Weight
{
    /**
     * @var string
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     */
    private string $value;

    /**
     * Weight constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::numeric($value);
        Assert::greaterThan($value, 0);

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
