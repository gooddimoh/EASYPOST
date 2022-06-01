<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use App\Infrastructure\Services\UuidGenerator;
use Webmozart\Assert\Assert;
use Exception;

/**
 * Class Id
 *
 * @package App\Model\Label\Entity\Carrier\Fields
 */
class Id
{
    /**
     * @var string
     */
    private string $value;

    /**
     * @return Id
     * @throws Exception
     */
    public static function next(): self
    {
        return new self(UuidGenerator::generate());
    }

    /**
     * Id constructor.
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
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
