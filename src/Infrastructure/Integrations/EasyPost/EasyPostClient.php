<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost;

use App\Infrastructure\Exceptions\MiscommunicationException;
use App\Infrastructure\Integrations\EasyPost\DTO\Carrier\Carrier;
use App\Infrastructure\Integrations\EasyPost\DTO\Pickup\Pickup;
use App\Infrastructure\Integrations\EasyPost\DTO\Shipment\Shipment;
use EasyPost\CarrierAccount;
use EasyPost\Error;
use EasyPost\Pickup as EasyPostPickup;
use EasyPost\Shipment as EasyPostShipment;
use EasyPost\Rate;
use EasyPost\EasyPost;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class EasyPostClient
 *
 * @package App\Infrastructure\Integrations\EasyPost
 */
class EasyPostClient
{
    /**
     * EasyPostClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        EasyPost::setApiKey($apiKey);
    }

    /**
     * @param Carrier $carrier
     *
     * @return CarrierAccount
     */
    public function createCarrier(Carrier $carrier): CarrierAccount
    {
        try {
            $carrierAccount = CarrierAccount::create(
                [
                    'type' => $carrier->getType(),
                    'description' => $carrier->getDescription(),
                    'readable' => $carrier->getName(),
                    'credentials' => $carrier->getCredentials()
                ]
            );
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create carrier. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $carrierAccount;
    }

    /**
     * @param string  $carrierAccountId
     * @param Carrier $carrier
     *
     * @return CarrierAccount
     */
    public function updateCarrier(string $carrierAccountId, Carrier $carrier): CarrierAccount
    {
        try {
            $this->deleteCarrier($carrierAccountId);

            $carrierAccount = $this->createCarrier($carrier);
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to update carrier. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $carrierAccount;
    }

    /**
     * @param string $carrierAccountId
     *
     * @return CarrierAccount
     */
    public function deleteCarrier(string $carrierAccountId): CarrierAccount
    {
        try {
            $carrier = $this->retrieveCarrier($carrierAccountId);

            $carrierAccount = $carrier->delete();
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to delete carrier. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $carrierAccount;
    }

    /**
     * @param string $carrierAccountId
     *
     * @return CarrierAccount
     */
    public function retrieveCarrier(string $carrierAccountId): CarrierAccount
    {
        try {
            $carrierAccount = CarrierAccount::retrieve($carrierAccountId);
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve carrier. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $carrierAccount;
    }

    /**
     * @param Shipment $shipment
     *
     * @return EasyPostShipment
     */
    public function createShipment(Shipment $shipment): EasyPostShipment
    {
        $from = $shipment->getFrom();
        $to = $shipment->getTo();

        try {
            $easyPostShipment = EasyPostShipment::create(
                [
                    'from_address' => [
                        "name" => $from->getFullName(),
                        "company" => $from->getCompanyName(),
                        "street1" => $from->getStreet1(),
                        "street2" => $from->getStreet2(),
                        "city" => $from->getCity(),
                        "state" => $from->getState(),
                        "zip" => $from->getZip(),
                        "phone" => $from->getPhone(),
                    ],
                    'to_address' => [
                        "name" => $to->getFullName(),
                        "company" => $to->getCompanyName(),
                        "street1" => $to->getStreet1(),
                        "street2" => $to->getStreet2(),
                        "city" => $to->getCity(),
                        "state" => $to->getState(),
                        "zip" => $to->getZip(),
                        "phone" => $to->getPhone(),
                    ],
                    'parcel' => $shipment->getParcel()->toArray(),
                    'customs_info' => $shipment->getCustomsInfo(),
                    'carrier_accounts' => $shipment->getCarrierAccounts(),
                    'options' => $shipment->getOptions()
                ]
            );
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create shipment. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $easyPostShipment;
    }

    /**
     * @param string $rateId
     *
     *
     * @return Rate
     */
    public function retrieveShipmentRate(string $rateId): Rate
    {
        try {
            $rate = Rate::retrieve($rateId);
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve shipment rate. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        if (!$rate) {
            throw new NotFoundHttpException('Shipment rate not found.');
        }

        return $rate;
    }

    /**
     * @param string $shipmentId
     *
     * @return EasyPostShipment
     */
    public function retrieveShipment(string $shipmentId): EasyPostShipment
    {
        try {
            $easyPostShipment = EasyPostShipment::retrieve($shipmentId);
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve shipment. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $easyPostShipment;
    }

    /**
     * @param string $shipmentId
     * @param string $rateId
     *
     * @return EasyPostShipment
     */
    public function buyShipment(string $shipmentId, string $rateId): EasyPostShipment
    {
        $shipment = $this->retrieveShipment($shipmentId);
        $rate = $this->retrieveShipmentRate($rateId);

        try {
            $shipment = $shipment->buy($rate);
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to buy shipment. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $shipment;
    }

    /**
     * @param EasyPostShipment $shipment
     *
     * @return Rate[]
     */
    public function getShipmentRates(EasyPostShipment $shipment): array
    {
        try {
            $rates = $shipment->get_rates()->rates;
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve shipment rates. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $rates;
    }

    /**
     * @param Pickup $pickup
     *
     * @return EasyPostPickup
     */
    public function createPickup(Pickup $pickup): EasyPostPickup
    {
        $from = $pickup->getFrom();

        try {
            $easyPostPickup = EasyPostPickup::create(
                [
                    'address' => [
                        "name" => $from->getFullName(),
                        "company" => $from->getCompanyName(),
                        "street1" => $from->getStreet1(),
                        "street2" => $from->getStreet2(),
                        "city" => $from->getCity(),
                        "state" => $from->getState(),
                        "zip" => $from->getZip(),
                        "phone" => $from->getPhone(),
                    ],
                    'shipment' => $this->retrieveShipment($pickup->getShipmentId()),
                    'min_datetime' => $pickup->getMinDate(),
                    'max_datetime' => $pickup->getMaxDate(),
                    "is_account_address" => false,
                    'instructions' => $pickup->getInstructions()
                ]
            );
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create pickup. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $easyPostPickup;
    }

    /**
     * @param string $pickupId
     *
     * @return EasyPostPickup
     */
    public function retrievePickup(string $pickupId): EasyPostPickup
    {
        try {
            $pickup = EasyPostPickup::retrieve($pickupId);
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve pickup. %s.', $exception->getMessage()),
                0,
                $exception
            );
        }

        if (!$pickup instanceof EasyPostPickup) {
            throw new NotFoundHttpException('Pickup not found.');
        }

        return $pickup;
    }

    /**
     * @param string $pickupId
     * @param string $rateId
     *
     * @return array
     */
    public function retrievePickupRate(string $pickupId, string $rateId): array
    {
        $pickup = $this->retrievePickup($pickupId);
        $pickupRates = $pickup->pickup_rates;
        $rate = null;

        foreach ($pickupRates as $pickupRate) {
            if ($pickupRate->id === $rateId) {
                $rate = $pickupRate->__toArray(true);
            }
        }

        if (!$rate) {
            throw new NotFoundHttpException('Pickup rate not found.');
        }

        return $rate;
    }

    /**
     * @param string $pickupId
     * @param string $rateId
     *
     * @return EasyPostPickup
     */
    public function buyPickup(string $pickupId, string $rateId): EasyPostPickup
    {
        $pickup = $this->retrievePickup($pickupId);
        $rate = $this->retrievePickupRate($pickupId, $rateId);

        try {
            $pickup = $pickup->buy($rate);
        } catch (Error $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to buy pickup. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $pickup;
    }
}
