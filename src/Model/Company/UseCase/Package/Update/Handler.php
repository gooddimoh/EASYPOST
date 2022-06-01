<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Package\Update;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Entity\Package\Fields\{AvailableCompany, Id, Name, Price, Permissions};
use App\Model\Company\Entity\Package\Package;
use App\Model\Company\Repositories\Package\PackageRepositoryInterface;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Package\Update
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
        FlusherInterface           $flusher
    ) {
        $this->flusher = $flusher;
        $this->packageRepository = $packageRepository;
    }

    /**
     * @param Command $command
     *
     * @return Package
     * @throws \Exception
     */
    public function handle(Command $command): Package
    {
        $package = $this->packageRepository->get(new Id($command->id));

        $package->changeName(new Name($command->name));
        $package->changePrice(new Price($command->priceMonth, $command->priceLabel, $command->priceAdditional));
        $package->changePermission(new Permissions($command->permissions));
        $package->changeAvailableCompany(new AvailableCompany($command->availableCompany));

        $this->packageRepository->add($package);
        $this->flusher->flush($package);

        return $package;
    }
}
