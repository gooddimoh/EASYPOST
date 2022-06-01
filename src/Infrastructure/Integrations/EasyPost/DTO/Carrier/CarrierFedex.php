<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost\DTO\Carrier;

use App\Infrastructure\Enums\Model\Carrier\TypeEnum;

/**
 * Class CarrierFedex
 *
 * @package App\Infrastructure\Integrations\EasyPost\DTO\Carrier
 */
class CarrierFedex extends Carrier
{
    /**
     * @var string
     */
    private string $accountNumber;

    /**
     * @var string
     */
    private string $key;

    private string $paypalid;
    private string $userid;
    private string $walletcash;

    /**
     * @var string
     */
    private string $meterNumber;

    /**
     * @var string
     */
    private string $password;

    /**
     * CarrierFedex constructor.
     *
     * @param string $name
     * @param string $description
     * @param string $accountNumber
     * @param string $meterNumber
     * @param string $key
     * @param string $password
     */
    public function __construct(
        string $name,
        string $description,
        string $accountNumber,
        string $meterNumber,
        string $key,
        string $password
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->accountNumber = $accountNumber;
        $this->meterNumber = $meterNumber;
        $this->key = $key;
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getCredentials(): array
    {
        return [
            'account_number' => $this->accountNumber,
            'meter_number' => $this->meterNumber,
            'key' => $this->key,
            'password' => $this->password,
        ];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return TypeEnum::FEDEX;
    }
}
