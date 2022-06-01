<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\LinkPackage;

use App\Model\Company\Entity\Company\Company;
use App\Model\Company\Entity\Transaction\Fields\Balance;
use App\Model\Company\Entity\Transaction\Fields\Creator;
use App\Model\Company\Entity\Transaction\Fields\Description;
use App\Model\Company\Entity\Transaction\Fields\Status;
use App\Model\Company\Entity\Transaction\Fields\Type;
use App\Model\Company\Entity\Transaction\Transaction;
use App\Model\Company\Entity\Transaction\Fields\Id as TransactionId;
use App\Model\Company\Repositories\Company\Balance\BalanceRepositoryInterface;
use App\Model\Company\Repositories\Package\PackageRepositoryInterface;
use App\Model\Company\Entity\Package\Fields\Id as PackageId;
use App\Model\Company\Repositories\Transaction\TransactionRepositoryInterface;
use DateTimeImmutable;
use App\Model\Company\Entity\Company\Fields\{Id, Package};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Company\Repositories\Company\CompanyRepositoryInterface;

class Handler
{
    /**
     * @var CompanyRepositoryInterface
     */
    private CompanyRepositoryInterface $companyRepository;

    /**
     * @var PackageRepositoryInterface
     */
    private PackageRepositoryInterface $packageRepository;

    /**
     * @var BalanceRepositoryInterface
     */
    private BalanceRepositoryInterface $balanceRepository;

    /**
     * @var TransactionRepositoryInterface
     */
    private TransactionRepositoryInterface $transactionRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param TransactionRepositoryInterface $transactionRepository
     * @param CompanyRepositoryInterface     $companyRepository
     * @param PackageRepositoryInterface     $packageRepository
     * @param BalanceRepositoryInterface     $balanceRepository
     * @param FlusherInterface               $flusher
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        CompanyRepositoryInterface     $companyRepository,
        PackageRepositoryInterface     $packageRepository,
        BalanceRepositoryInterface     $balanceRepository,
        FlusherInterface               $flusher
    ) {
        $this->flusher = $flusher;
        $this->companyRepository = $companyRepository;
        $this->packageRepository = $packageRepository;
        $this->balanceRepository = $balanceRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param Command $command
     *
     * @return Company
     * @throws \Exception
     */
    public function handle(Command $command): Company
    {
        $package = $this->packageRepository->get(new PackageId($command->package));
        $company = $this->companyRepository->get(new Id($command->id));
        $balance = $this->balanceRepository->get($company->getId());

        $packagePrice = $package->getPrice()->getMonth();

        $transaction = new Transaction(
            TransactionId::next(),
            new Description(sprintf('Payment for package - "%s"', $package->getName()->getValue())),
            new Balance($balance->getTotal(), $packagePrice),
            Type::debit(null, ['package' => $package->getId()->getValue()]),
            new Creator($command->modifiedId, $command->modifiedCompany),
            new DateTimeImmutable(),
            Status::success()
        );

        $balance->sub($packagePrice);

        $company->changePackage(new Package($package->getId()->getValue()));

        $this->transactionRepository->add($transaction);
        $this->balanceRepository->add($balance);
        $this->companyRepository->add($company);
        $this->flusher->flush();

        return $company;
    }
}
