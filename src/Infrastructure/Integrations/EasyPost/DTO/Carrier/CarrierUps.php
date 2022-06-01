<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost\DTO\Carrier;

use App\Infrastructure\Enums\Model\Carrier\TypeEnum;

/**
 * Class CarrierUps
 *
 * @package App\Infrastructure\Integrations\EasyPost\DTO\Carrier
 */
class CarrierUps extends Carrier
{
    /**
     * @var string
     */
    private string $accessLicenseNumber;

    /**
     * @var string
     */
    private string $accountNumber;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $userId;

    /**
     * CarrierUps constructor.
     *
     * @param string $name
     * @param string $description
     * @param string $accessLicenseNumber
     * @param string $accountNumber
     * @param string $userId
     * @param string $password
     */
    public function __construct(
        string $name,
        string $description,
        string $accessLicenseNumber,
        string $accountNumber,
        string $userId,
        string $password
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->accessLicenseNumber = $accessLicenseNumber;
        $this->accountNumber = $accountNumber;
        $this->userId = $userId;
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getCredentials(): array
    {
        return [
            'access_license_number' => $this->accessLicenseNumber,
            'account_number' => $this->accountNumber,
            'user_id' => $this->userId,
            'password' => $this->password,
        ];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return TypeEnum::UPS;
    }
}