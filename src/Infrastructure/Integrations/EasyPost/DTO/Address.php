<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost\DTO;

/**
 * Class Address
 *
 * @package App\Infrastructure\Integrations\EasyPost\DTO
 */
class Address
{
    /**
     * @var string
     */
    private string $city;

    /**
     * @var string
     */
    private string $companyName;

    /**
     * @var string
     */
    private string $country;

    /**
     * @var string
     */
    private string $fullName;

    /**
     * @var string
     */
    private string $phoneCode;

    /**
     * @var string
     */
    private string $phoneNumber;

    /**
     * @var string
     */
    private string $state;

    /**
     * @var string
     */
    private string $street1;

    /**
     * @var string
     */
    private string $street2;

    /**
     * @var string
     */
    private string $zip;

    /**
     * Address constructor.
     *
     * @param string $fullName
     * @param string $companyName
     * @param string $phoneCode
     * @param string $phoneNumber
     * @param string $country
     * @param string $state
     * @param string $city
     * @param string $zip
     * @param string $street1
     * @param string $street2
     */
    public function __construct(
        string $fullName,
        string $companyName,
        string $phoneCode,
        string $phoneNumber,
        string $country,
        string $state,
        string $city,
        string $zip,
        string $street1,
        string $street2 = ''
    )
    {
        $this->fullName = $fullName;
        $this->companyName = $companyName;
        $this->phoneCode = $phoneCode;
        $this->phoneNumber = $phoneNumber;
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
        $this->zip = $zip;
        $this->street1 = $street1;
        $this->street2 = $street2;
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
    public function getCompanyName(): string
    {
        return $this->companyName;
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
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return sprintf('%s%s', $this->phoneCode, $this->phoneNumber);
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
    public function getStreet1(): string
    {
        return $this->street1;
    }

    /**
     * @return string
     */
    public function getStreet2(): string
    {
        return $this->street2;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }
}

class ProductDto
{
    public int $id;
    public string $name;
    public int $categoryId;

    public function __construct()
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
