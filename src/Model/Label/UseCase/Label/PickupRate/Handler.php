<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\PickupRate;

use App\Infrastructure\Factory\PrimitiveTypes\Decimal;
use App\Infrastructure\Integrations\EasyPost\DTO\Address;
use App\Infrastructure\Integrations\EasyPost\DTO\Pickup\Pickup;
use App\Infrastructure\Integrations\EasyPost\EasyPostClient;
use App\Model\Label\Entity\Label\Fields\Id;
use App\Model\Label\Repositories\Label\LabelRepositoryInterface;

/**
 * Class Handler
 *
 * @package App\Model\Label\UseCase\Label\PickupRate
 */
class Handler
{
    /**
     * @var EasyPostClient
     */
    private EasyPostClient $easyPostClient;

    /**
     * @var LabelRepositoryInterface
     */
    private LabelRepositoryInterface $labelRepository;

    /**
     * Handler constructor.
     *
     * @param EasyPostClient           $easyPostClient
     * @param LabelRepositoryInterface $labelRepository
     */
    public function __construct(
        EasyPostClient $easyPostClient,
        LabelRepositoryInterface $labelRepository
    ) {
        $this->easyPostClient = $easyPostClient;
        $this->labelRepository = $labelRepository;
    }

    /**
     * @return array
     */
    public function getPickupRatesColumns(): array
    {
        return ['service_type', 'amount'];
    }

    /**
     * @param Command $command
     *
     * @return array
     */
    public function handle(Command $command): array
    {
        $label = $this->labelRepository->get(new Id($command->id));

        $pickup = $this->easyPostClient->createPickup(
            new Pickup(
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
                $label->getShipment()->getId(),
                $command->minDate,
                $command->maxDate,
                $command->instructions
            )
        );

        if ($pickup->messages !== []) {
            throw new \DomainException($pickup->messages[0]->message);
        }

        return [
            'pickup_id' => $pickup->id,
            'items' => $this->prepareRates($pickup->pickup_rates)
        ];
    }

    /**
     * @param array $rates
     *
     * @return array
     */
    private function prepareRates(array $rates): array
    {
        $items = [];

        foreach ($rates as $rate) {
            $items[] = [
                'id' => $rate->id,
                'service_type' => sprintf('%s %s', $rate->carrier, $rate->service),
                'amount' => Decimal::create($rate->rate)->mul(100)->toInt(),
            ];
        }

        return $items;
    }
}
