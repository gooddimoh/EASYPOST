<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\ShipmentRate;

use App\Infrastructure\Factory\PrimitiveTypes\Decimal;
use App\Infrastructure\Integrations\EasyPost\DTO\Address;
use App\Infrastructure\Integrations\EasyPost\DTO\Shipment\Parcel;
use App\Infrastructure\Integrations\EasyPost\DTO\Shipment\Shipment;
use App\Infrastructure\Integrations\EasyPost\EasyPostClient;
use EasyPost\Rate;

/**
 * Class Handler
 *
 * @package App\Model\Label\UseCase\Label\ShipmentRate
 */
class Handler
{
    /**
     * @var EasyPostClient
     */
    private EasyPostClient $easyPostClient;

    /**
     * Handler constructor.
     *
     * @param EasyPostClient $easyPostClient
     */
    public function __construct(EasyPostClient $easyPostClient)
    {
        $this->easyPostClient = $easyPostClient;
    }

    /**
     * @return array
     */
    public function getShipmentRatesColumns(): array
    {
        return ['service_type', 'amount', 'time_delivery'];
    }

    /**
     * @param Command $command
     *
     * @return array
     */
    public function handle(Command $command): array
    {
        $shipment = $this->easyPostClient->createShipment(
            new Shipment(
                new Address(
                    $command->senderName,
                    $command->senderName,
                    $command->senderCode,
                    $command->senderPhone,
                    $command->senderCountry,
                    $command->senderState,
                    $command->senderCity,
                    $command->senderZip,
                    $command->senderStreet1,
                    $command->senderStreet2,
                ),
                new Address(
                    $command->recipientName,
                    $command->recipientName,
                    $command->recipientCode,
                    $command->recipientPhone,
                    $command->recipientCountry,
                    $command->recipientState,
                    $command->recipientCity,
                    $command->recipientZip,
                    $command->recipientStreet1,
                    $command->recipientStreet2,
                ),
                new Parcel(
                    $command->weight,
                    $command->length,
                    $command->width,
                    $command->height,
                ),
                array_map(fn($carrier) => $carrier['carrier_account'], $command->availableCarriers),
                $command->packages,
                $command->options
            )
        );

        if ($shipment->messages !== []) {
            throw new \DomainException($shipment->messages[0]->message);
        }

        return [
            'shipment_id' => $shipment->id,
            'items' => $this->prepareRates(
                $this->easyPostClient->getShipmentRates($shipment),
                $command->companyLabelPrice
            )
        ];
    }

    /**
     * @param Rate[] $rates
     * @param int    $companyLabelPrice
     *
     * @return array
     */
    private function prepareRates(array $rates, int $companyLabelPrice): array
    {
        $items = [];

        foreach ($rates as $rate) {
            $items[] = [
                'id' => $rate->id,
                'service_type' => sprintf('%s %s', $rate->carrier, $rate->service),
                'amount' => $companyLabelPrice + Decimal::create($rate->rate)->mul(100)->toInt(),
                'time_delivery' => $rate->delivery_days ?? 0
            ];
        }

        return $items;
    }
}
