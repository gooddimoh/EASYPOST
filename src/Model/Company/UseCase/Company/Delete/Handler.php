<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Delete;

use App\Model\Company\Entity\Company\Fields\Status;
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Entity\Company\Fields\Id;
use App\Model\Company\Repositories\Company\CompanyRepositoryInterface;
use Exception;

/**
 * Class Handler
 * @package App\Model\Company\UseCase\Company\Delete
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
     * @param CompanyRepositoryInterface $companyRepository
     * @param FlusherInterface $flusher
     */
    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        FlusherInterface $flusher
    )
    {
        $this->flusher = $flusher;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param Command $command
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        $company = $this->companyRepository->get(new Id($command->id));
        $company->changeStatus(Status::block());

        $this->companyRepository->add($company);

        $this->flusher->flush($company);
    }
}
