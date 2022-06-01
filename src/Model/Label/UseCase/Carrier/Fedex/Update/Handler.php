<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Carrier\Fedex\Update;

use App\Infrastructure\Integrations\EasyPost\DTO\Carrier\CarrierFedex;
use App\Infrastructure\Integrations\EasyPost\EasyPostClient;
use App\Model\Label\Entity\Carrier\Carrier;
use App\Model\Label\Entity\Carrier\Fields\CarrierAccount;
use App\Model\Label\Entity\Carrier\Fields\Creator;
use App\Model\Label\Entity\Carrier\Fields\Credentials;
use App\Model\Label\Entity\Carrier\Fields\Id;
use App\Model\Label\Entity\Carrier\Fields\Status;
use App\Model\Label\Repositories\Carrier\CarrierRepositoryInterface;
use App\Infrastructure\Flusher\FlusherInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Label\UseCase\Carrier\Fedex\Update
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
     * @return Carrier
     * @throws Exception
     */
    public function handle(Command $command): Carrier
    {
        $carrier = $this->carrierRepository->get(new Id($command->id));

        if (!$carrier->isEditable()) {
            throw new \DomainException('Carrier forbidden to edit.');
        }

        $carrierFedexDto = new CarrierFedex(
            $carrier->getName()->getValue(),
            $carrier->getDescription()->getValue(),
            $command->accountNumber,
            $command->meterNumber,
            $command->key,
            $command->password
        );

        $newCredentials = new Credentials($carrierFedexDto->getCredentials());

        if ($carrier->getCredentials()->isEqual($newCredentials)) {
            return $carrier;
        }

        $carrierEasyPost = $this->easyPostClient->updateCarrier(
            $carrier->getCarrierAccount()->getValue(),
            $carrierFedexDto
        );

        $carrier->block();

        $newCarrier = new Carrier(
            Id::next(),
            $carrier->getName(),
            $carrier->getType(),
            $carrier->getDescription(),
            new CarrierAccount($carrierEasyPost->id),
            $newCredentials,
            $carrier->getCustom(),
            $carrier->getEditable(),
            Status::active(),
            new DateTimeImmutable(),
            new Creator($command->modifiedId, $command->modifiedCompany)
        );

        $this->carrierRepository->add($newCarrier);
        $this->flusher->flush($newCarrier);

        return $newCarrier;
    }
}
