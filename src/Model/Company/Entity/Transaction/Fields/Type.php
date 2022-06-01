<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Transaction\Fields;

use App\Infrastructure\Enums\Model\Transaction\MethodEnum;
use App\Infrastructure\Enums\Model\Transaction\TypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Type
 * @package App\Model\Company\Entity\Transaction\Fields
 * @ORM\Embeddable
 */
class Type
{
    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $value;

    /**
     * @var int|null
     * @ORM\Column(type="smallint", nullable=true)
     */
    private ?int $method;

    /**
     * @var array|null
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $options;

    /**
     * Type constructor.
     * @param int $value
     * @param int|null $method
     * @param array|null $options
     */
    private function __construct(int $value, ?int $method, ?array $options)
    {
        Assert::oneOf($value, TypeEnum::getAll());

        $this->method = $method;
        $this->options = $options;

        $this->value = $value;
    }

    /**
     * @param int|null $method
     * @param array|null $options
     * @return $this
     */
    public static function debit(?int $method = null, ?array $options = null): self
    {
        return new self(TypeEnum::DEBIT, $method, $options);
    }

    /**
     * @param int $method
     * @param array|null $options
     * @return $this
     */
    public static function credit(int $method, ?array $options): self
    {
        Assert::oneOf($method, MethodEnum::getAll());

        return new self(TypeEnum::CREDIT, $method, $options);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getMethod(): int
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
