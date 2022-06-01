<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\Draft\Update;

use DateTimeImmutable;
use App\Model\Label\Entity\Label\Fields\{Description,
    Destination,
    Id,
    Options,
    Package\Fields\Creator as CreatorPackage,
    Package\Fields\Description as DescriptionPackage,
    Package\Fields\Price as PricePackage,
    Package\Fields\Quantity as QuantityPackage,
    Package\Fields\Weight as WeightPackage,
    Package\Package,
    Parcel
};
use App\Model\Label\Entity\Label\Label;
use App\Model\Label\Repositories\Label\LabelRepositoryInterface;
use App\Infrastructure\Flusher\FlusherInterface;
use DomainException;

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
     * @throws \Exception
     */
    public function handle(Command $command): Label
    {
        $label = $this->labelRepository->get(new Id($command->id));

        if (!$label->isDraft()) {
            throw new DomainException('Only draft labels can be edited.');
        }

        $label->changeDescription(new Description($command->description));

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

        $label->changeOptions(new Options($command->options));
        $label->changeSender(
            new Destination(
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
                $command->senderZip
            )
        );
        $label->changeRecipient(
            new Destination(
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
            )
        );
        $label->changeParcel(
            new Parcel(
                $command->weight,
                $command->length ?: null,
                $command->width ?: null,
                $command->height ?: null
            )
        );

        $this->labelRepository->add($label);
        $this->flusher->flush($label);

        return $label;
    }
}
