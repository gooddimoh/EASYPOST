<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost\DTO\Shipment;

use App\Infrastructure\Factory\PrimitiveTypes\Decimal;
use App\Infrastructure\Integrations\EasyPost\DTO\Address;

/**
 * Class Shipment
 *
 * @package App\Infrastructure\Integrations\EasyPost\DTO\Shipment
 */
class Shipment
{
    /**
     * @var array
     */
    private array $customsInfo;

    /**
     * @var array
     */
    private array $carrierAccounts;

    /**
     * @var Address
     */
    private Address $from;

    /**
     * @var array
     */
    private array $options;

    /**
     * @var Address
     */
    private Address $to;

    /**
     * @var Parcel
     */
    private Parcel $parcel;

    /**
     * Shipment constructor.
     *
     * @param Address $from
     * @param Address $to
     * @param Parcel  $parcel
     * @param array   $carrierAccounts
     * @param array   $packages
     * @param array   $options
     */
    public function __construct(
        Address $from,
        Address $to,
        Parcel  $parcel,
        array   $carrierAccounts,
        array   $packages,
        array   $options = []
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->parcel = $parcel;
        $this->carrierAccounts = $carrierAccounts;
        $this->customsInfo = $this->prepareCustomsInfo($packages);
        $this->options = array_merge($options, ['label_format' => 'PDF']);
    }

    /**
     * @return array
     */
    public function getCarrierAccounts(): array
    {
        return $this->carrierAccounts;
    }

    /**
     * @return array
     */
    public function getCustomsInfo(): array
    {
        return $this->customsInfo;
    }

    /**
     * @return Address
     */
    public function getFrom(): Address
    {
        return $this->from;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return Address
     */
    public function getTo(): Address
    {
        return $this->to;
    }

    /**
     * @return Parcel
     */
    public function getParcel(): Parcel
    {
        return $this->parcel;
    }

    /**
     * @param array $packages
     *
     * @return array
     */
    private function prepareCustomsInfo(array $packages): array
    {
        $customsItems = [];

        foreach ($packages as $package) {
            $customsItems[] = [
                'description' => $package['description'],
                'quantity' => $package['quantity'],
                'weight' => $package['weight'] * $package['quantity'],
                'value' => Decimal::create($package['price'] * $package['quantity'])->div(100)->toString(),
                // из центов в доллары
            ];
        }

        return [
            'customs_items' => $customsItems,
            'customs_signer' => $this->from->getFullName(),
            'contents_type' => 'gift',
            'customs_certify' => true,
        ];
    }
}