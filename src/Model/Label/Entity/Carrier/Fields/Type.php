<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use App\Infrastructure\Enums\Model\Carrier\TypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Type
 *
 * @package App\Model\Label\Entity\Carrier\Fields
 * @ORM\Embeddable
 */
class Type
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * @return static
     */
    public static function fedex(): self
    {
        return new self(TypeEnum::FEDEX);
    }

    /**
     * @return static
     */
    public static function ups(): self
    {
        return new self(TypeEnum::UPS);
    }

    /**
     * @return static
     */
    public static function usps(): self
    {
        return new self(TypeEnum::USPS);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
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
     * Type constructor.
     *
     * @param string $value
     */
    private function __construct(string $value)
    {
        Assert::oneOf($value, TypeEnum::getAll());

        $this->value = $value;
    }
}
