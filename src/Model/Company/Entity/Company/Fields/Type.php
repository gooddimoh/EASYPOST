<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company\Fields;

use App\Infrastructure\Enums\Model\Company\TypeEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Type
 *
 * @package App\Model\Company\Entity\Company\Fields
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
     * Type constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::oneOf($value, TypeEnum::getAll());

        $this->value = $value;
    }

    /**
     * @param Type $newType
     *
     * @return bool
     */
    public function canChange(self $newType): bool
    {
        return $this->isSinglePerson() && $newType->isCompany();
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isCompany(): bool
    {
        return $this->value === TypeEnum::COMPANY;
    }

    /**
     * @param self $type
     *
     * @return bool
     */
    public function isEqual(self $type): bool
    {
        return $this->value === $type->getValue();
    }

    /**
     * @return bool
     */
    public function isSinglePerson(): bool
    {
        return $this->value === TypeEnum::SINGLE_PERSON;
    }
}
