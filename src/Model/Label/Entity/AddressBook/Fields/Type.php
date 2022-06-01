<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\AddressBook\Fields;

use App\Infrastructure\Enums\Model\AddressBook\{AddressEnum, TypeEnum};
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Type
 * @package App\Model\Label\Entity\AddressBook\Fields
 * @ORM\Embeddable
 */
class Type
{
    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $record;

    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $address;

    /**
     * Type constructor.
     * @param int $type
     * @param int $address
     */
    public function __construct(int $type, int $address)
    {
        Assert::oneOf($type, TypeEnum::getAll());
        Assert::oneOf($address, AddressEnum::getAll());

        $this->record = $type;
        $this->address = $address;
    }


    /**
     * @param self $type
     * @return bool
     */
    public function isEqual(self $type): bool
    {
        return $this->record === $type->getRecord() &&
            $this->address === $type->getAddress();
    }

    /**
     * @return int
     */
    public function getRecord(): int
    {
        return $this->record;
    }

    /**
     * @return int
     */
    public function getAddress(): int
    {
        return $this->address;
    }
}
