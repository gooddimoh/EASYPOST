<?php

declare(strict_types=1);

namespace App\Services\Transaction\Controller;

use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\Transaction\TransactionFetcher;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class TransactionService
 * @package App\Services\Company\Controller
 */
class TransactionService
{
    /**
     * @var TransactionFetcher
     */
    private TransactionFetcher $fetcher;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * AddressBookService constructor.
     * @param TransactionFetcher $fetcher
     * @param Security $security
     */
    public function __construct(TransactionFetcher $fetcher, Security $security)
    {
        $this->fetcher = $fetcher;
        $this->security = $security;
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     * @return PaginationInterface
     * @throws ExceptionInterface
     */
    public function getItems(PaginationRequestInterface $paginationRequest): PaginationInterface
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $paginationRequest->getFilter()->addFilter([
                'company_id' => $this->security->getUser()->getCompany(),
            ]);
        }

        return $this->fetcher->all($paginationRequest);
    }

    /**
     * @param string|null $name
     * @param string $id
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getList(?string $name, string $id = ''): array
    {
        return $this->fetcher->getList($name, $id, ['company_id' => $this->security->getUser()->getCompany()]);
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return $this->fetcher->getTableColumns();
    }
}
