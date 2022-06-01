<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use App\Infrastructure\Enums\Model\AddressBook\AddressEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Destination
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Destination
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $name;

    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $type;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private ?string $code;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private ?string $phone;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $email;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $street1;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $street2;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $city;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $state;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $country;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $zip;

    /**
     * Destination constructor.
     * @param string $name
     * @param int $type
     * @param string|null $code
     * @param string|null $phone
     * @param string|null $email
     * @param string $street1
     * @param string $street2
     * @param string $city
     * @param string $state
     * @param string $country
     * @param string $zip
     */
    public function __construct(
        string $name,
        int $type,
        ?string $code,
        ?string $phone,
        ?string $email,
        string $street1,
        string $street2,
        string $city,
        string $state,
        string $country,
        string $zip
    )
    {
        Assert::notEmpty($name);
        Assert::notEmpty($street1);
        Assert::notEmpty($city);
        Assert::notEmpty($state);
        Assert::notEmpty($country);
        Assert::notEmpty($zip);
        Assert::oneOf($type, AddressEnum::getAll());

        $this->name = $name;
        $this->type = $type;
        $this->street1 = $street1;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zip = $zip;

        $this->street2 = $street2 ? $street2 : null;
        $this->code = $code ? $code : null;
        $this->phone = $phone ? $phone : null;
        $this->email = $email ? $email : null;
    }

    /**
     * @param self $name
     * @return bool
     */
    public function isEqual(self $name): bool
    {
        return $this->getFull() === $name->getFull();
    }

    /**
     * @return string
     */
    public function getFull(): string
    {
        return implode(' ', array_filter([
            $this->name,
            $this->phone,
            $this->email,
            $this->street1,
            $this->street2,
            $this->city,
            $this->state,
            $this->country,
            $this->zip
        ]));
    }

    /**
     * @return string
     */
    public function getStreet1(): string
    {
        return $this->street1;
    }

    /**
     * @return string|null
     */
    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}
