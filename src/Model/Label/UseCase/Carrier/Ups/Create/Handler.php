<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Carrier\Ups\Create;

use App\Infrastructure\Enums\Model\Carrier\TypeEnum;
use App\Infrastructure\Integrations\EasyPost\DTO\Carrier\CarrierUps;
use App\Infrastructure\Integrations\EasyPost\EasyPostClient;
use App\Model\Label\Entity\Carrier\Carrier;
use App\Model\Label\Entity\Carrier\Fields\CarrierAccount;
use App\Model\Label\Entity\Carrier\Fields\Creator;
use App\Model\Label\Entity\Carrier\Fields\Credentials;
use App\Model\Label\Entity\Carrier\Fields\Custom;
use App\Model\Label\Entity\Carrier\Fields\Description;
use App\Model\Label\Entity\Carrier\Fields\Editable;
use App\Model\Label\Entity\Carrier\Fields\Id;
use App\Model\Label\Entity\Carrier\Fields\Name;
use App\Model\Label\Entity\Carrier\Fields\Status;
use App\Model\Label\Entity\Carrier\Fields\Type;
use App\Model\Label\Repositories\Carrier\CarrierRepositoryInterface;
use App\Infrastructure\Flusher\FlusherInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Label\UseCase\Carrier\Ups\Create
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
        $existsCustom = $this->carrierRepository->existsCustom($command->modifiedCompany, TypeEnum::UPS);

        if ($existsCustom) {
            throw new \DomainException('Carrier already exists.');
        }

        $carrierUpsDto = new CarrierUps(
            $command->name,
            sprintf('Carrier for company "%s"', $command->modifiedCompany),
            $command->accessLicenseNumber,
            $command->accountNumber,
            $command->userId,
            $command->password
        );

        $carrierEasyPost = $this->easyPostClient->createCarrier($carrierUpsDto);

        $carrier = new Carrier(
            Id::next(),
            new Name($carrierUpsDto->getName()),
            Type::ups(),
            new Description($carrierUpsDto->getDescription()),
            new CarrierAccount($carrierEasyPost->id),
            new Credentials($carrierUpsDto->getCredentials()),
            Custom::yes(),
            Editable::yes(),
            Status::active(),
            new DateTimeImmutable(),
            new Creator($command->modifiedId, $command->modifiedCompany)
        );

        $this->carrierRepository->add($carrier);
        $this->flusher->flush($carrier);

        return $carrier;
    }
}
