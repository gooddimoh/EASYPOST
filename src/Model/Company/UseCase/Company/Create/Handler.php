<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Create;

use App\Model\Company\Entity\Company\Company;
use App\Model\Company\Entity\Company\Fields\{Creator, Name, Id, Photo, Status, Package, Type};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Repositories\Company\CompanyRepositoryInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Company\Create
 */
class Handler
{
    /**
     * @var CompanyRepositoryInterface
     */
    private CompanyRepositoryInterface $companyRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param CompanyRepositoryInterface $companyRepository
     * @param FlusherInterface           $flusher
     */
    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        FlusherInterface           $flusher
    ) {
        $this->flusher = $flusher;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param Command $command
     *
     * @return Company
     * @throws Exception
     */
    public function handle(Command $command): Company
    {
        $company = new Company(
            Id::next(),
            new Name($command->name),
            new Type($command->type),
            new Photo($command->photo),
            new Package($command->package),
            new Creator($command->modifiedId, $command->modifiedCompany),
            new DateTimeImmutable(),
            Status::active(),
        );

        $this->companyRepository->add($company);
        $this->flusher->flush($company);

        return $company;
    }
}
