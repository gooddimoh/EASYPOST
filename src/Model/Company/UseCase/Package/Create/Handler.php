<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Package\Create;

use App\Model\Company\Entity\Package\Package;
use App\Model\Company\Repositories\Package\PackageRepositoryInterface;
use App\Model\Company\Entity\Package\Fields\{AvailableCompany, Id, Creator, Name, Price, Permissions, Status};
use App\Infrastructure\Flusher\FlusherInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Package\Create
 */
class Handler
{
    /**
     * @var PackageRepositoryInterface
     */
    private PackageRepositoryInterface $packageRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param PackageRepositoryInterface $packageRepository
     * @param FlusherInterface           $flusher
     */
    public function __construct(
        PackageRepositoryInterface $packageRepository,
        FlusherInterface $flusher
    ) {
        $this->flusher = $flusher;
        $this->packageRepository = $packageRepository;
    }

    /**
     * @param Command $command
     *
     * @return Package
     * @throws Exception
     */
    public function handle(Command $command): Package
    {
        $package = new Package(
            Id::next(),
            new Name($command->name),
            new Price($command->priceMonth, $command->priceLabel, $command->priceAdditional),
            new Permissions(array_merge($command->permissions, ['ROLE_USE_USPS'])),
            new AvailableCompany($command->availableCompany),
            new Creator($command->modifiedId, $command->modifiedCompany),
            new DateTimeImmutable(),
            Status::active(),
        );

        $this->packageRepository->add($package);
        $this->flusher->flush($package);

        return $package;
    }
}
