<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Registration\Update;

use App\Model\Company\Entity\Company\Company;
use App\Model\Company\Entity\Company\Fields\{Id, Name, Type};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Repositories\Company\CompanyRepositoryInterface;

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
        $company = $this->companyRepository->get(new Id($command->companyId));

        $company->changeName(new Name($command->companyName));
        $company->changeType(new Type($command->companyType));

        $this->companyRepository->add($company);
        $this->flusher->flush($company);

        return $company;
    }
}
