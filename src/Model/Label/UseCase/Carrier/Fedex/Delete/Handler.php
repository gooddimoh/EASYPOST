<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Carrier\Fedex\Delete;

use App\Infrastructure\Integrations\EasyPost\EasyPostClient;
use App\Model\Label\Entity\Carrier\Fields\Id;
use App\Model\Label\Repositories\Carrier\CarrierRepositoryInterface;
use App\Infrastructure\Flusher\FlusherInterface;

/**
 * Class Handler
 *
 * @package App\Model\Label\UseCase\Carrier\Fedex\Delete
 */
class Handler
{
    /**
     * @var CarrierRepositoryInterface
     */
    private CarrierRepositoryInterface $carrierRepository;

    /**
     * @var EasyPostClient
     */
    private EasyPostClient $easyPostClient;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param CarrierRepositoryInterface $carrierRepository
     * @param EasyPostClient             $easyPostClient
     * @param FlusherInterface           $flusher
     */
    public function __construct(
        CarrierRepositoryInterface $carrierRepository,
        EasyPostClient $easyPostClient,
        FlusherInterface $flusher
    ) {
        $this->flusher = $flusher;
        $this->carrierRepository = $carrierRepository;
        $this->easyPostClient = $easyPostClient;
    }

    /**
     * @param Command $command
     *
     * @return void
     */
    public function handle(Command $command): void
    {
        $carrier = $this->carrierRepository->get(new Id($command->id));

        if (!$carrier->isEditable()) {
            throw new \DomainException('Carrier forbidden to delete.');
        }

        $this->easyPostClient->deleteCarrier(
            $carrier->getCarrierAccount()->getValue()
        );

        $carrier->block();

        $this->flusher->flush($carrier);
    }
}
