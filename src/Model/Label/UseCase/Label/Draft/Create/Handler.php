<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\Draft\Create;

use App\Model\Label\Entity\Label\Label;
use App\Model\Label\Entity\Label\Fields\{Id,
    Shipment,
    Type,
    Status,
    Options,
    Creator,
    Description,
    Destination,
    Information,
    Parcel
};
use App\Model\Label\Entity\Label\Fields\Package\Fields\{
    Price as PricePackage,
    Description as DescriptionPackage,
    Creator as CreatorPackage,
    Weight as WeightPackage,
    Quantity as QuantityPackage,
};
use App\Model\Label\Entity\Label\Fields\Package\Package;
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Label\Repositories\Label\LabelRepositoryInterface;
use DateTimeImmutable;
use Exception;

class Handler
{
    /**
     * @var LabelRepositoryInterface
     */
    private LabelRepositoryInterface $labelRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param LabelRepositoryInterface $labelRepository
     * @param FlusherInterface         $flusher
     */
    public function __construct(
        LabelRepositoryInterface $labelRepository,
        FlusherInterface         $flusher
    ) {
        $this->flusher = $flusher;
        $this->labelRepository = $labelRepository;
    }

    /**
     * @param Command $command
     *
     * @return Label
     * @throws Exception
     */
    public function handle(Command $command): Label
    {
        $labelId = Id::next();

        $sender = new Destination(
            $command->senderName,
            $command->senderType,
            $command->senderCode,
            $command->senderPhone,
            $command->senderEmail,
            $command->senderStreet1,
            $command->senderStreet2,
            $command->senderCity,
            $command->senderState,
            $command->senderCountry,
            $command->senderZip,
        );

        $recipient = new Destination(
            $command->recipientName,
            $command->recipientType,
            $command->recipientCode,
            $command->recipientPhone,
            $command->recipientEmail,
            $command->recipientStreet1,
            $command->recipientStreet2,
            $command->recipientCity,
            $command->recipientState,
            $command->recipientCountry,
            $command->recipientZip
        );

        $label = new Label(
            $labelId,
            new Type($command->type),
            new Shipment(),
            new Parcel(
                $command->weight,
                $command->length ?: null,
                $command->width ?: null,
                $command->height ?: null
            ),
            $sender,
            $recipient,
            new Information(),
            new Description($command->description),
            Status::draft(),
            new Options($command->options),
            new DateTimeImmutable(),
            new Creator($command->modifiedId, $command->modifiedCompany)
        );

        if ($label->isWorld()) {
            $packages = array_map(
                static fn(array $package): Package => new Package(
                    new PricePackage((int) $package['price']),
                    new WeightPackage($package['weight']),
                    new QuantityPackage(+$package['quantity']),
                    new DescriptionPackage($package['description']),
                    new CreatorPackage($command->modifiedId, $command->modifiedCompany),
                    new DateTimeImmutable(),
                    $label
                ),
                $command->packages
            );

            $label->changePackages($packages);
        }

        $this->labelRepository->add($label);
        $this->flusher->flush($label);

        return $label;
    }
}
