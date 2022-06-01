<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\AddressBook\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Address
 * @package App\Model\Label\Entity\AddressBook\Fields
 * @ORM\Embeddable
 */
class Address
{
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
     * Address constructor.
     * @param string $street1
     * @param string $street2
     * @param string $city
     * @param string $state
     * @param string $country
     * @param string $zip
     */
    public function __construct(
        string $street1,
        string $street2,
        string $city,
        string $state,
        string $country,
        string $zip
    ) {
        Assert::notEmpty($street1);
        Assert::notEmpty($city);
        Assert::notEmpty($state);
        Assert::notEmpty($country);
        Assert::notEmpty($zip);

        $this->street1 = $street1;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zip = $zip;

        $this->street2 = $street2 ? $street2 : null;
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
}
