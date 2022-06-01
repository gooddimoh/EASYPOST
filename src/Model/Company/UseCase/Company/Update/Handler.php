<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Update;

use App\Model\Company\Entity\Company\Company;
use App\Model\Company\Entity\Company\Fields\{Id, Name, Photo, Type};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Repositories\Company\CompanyRepositoryInterface;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Company\Update
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
     * @throws \Exception
     */
    public function handle(Command $command): Company
    {
        $company = $this->companyRepository->get(new Id($command->id));

        $company->changeName(new Name($command->name));
        $company->changeType(new Type($command->type));
        $company->changePhoto(new Photo($command->photo));

        $this->companyRepository->add($company);
        $this->flusher->flush($company);

        return $company;
    }
}
