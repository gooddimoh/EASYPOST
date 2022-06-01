<?php

declare(strict_types=1);

namespace App\Services\AddressBook\Controller;

use App\Infrastructure\Enums\Model\AddressBook\TypeEnum;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\ReadModels\AddressBook\AddressBookFetcher;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class AddressBook
 * @package App\Services\AddressBook\Controller
 */
class AddressBookService
{
    /**
     * @var AddressBookFetcher
     */
    private AddressBookFetcher $fetcher;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * AddressBookService constructor.
     * @param AddressBookFetcher $fetcher
     * @param Security $security
     */
    public function __construct(AddressBookFetcher $fetcher, Security $security)
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
        $paginationRequest->getFilter()->addFilter($this->permissionFilters([]));
        return $this->fetcher->all($paginationRequest);
    }

    /**
     * @param string|null $name
     * @param string|null $id
     * @param string|null $country
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getListSender(?string $name, ?string $id = '', ?string $country = null): array
    {
        $filter = $this->permissionFilters([
            'type' => TypeEnum::SENDER,
            'country' => $country
        ]);
        return $this->fetcher->getList($name, $id, $filter);
    }

    /**
     * @param string|null $name
     * @param string|null $id
     * @param string|null $country
     * @return array
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getListRecipient(?string $name, ?string $id = '', ?string $country = null): array
    {
        $filter = $this->permissionFilters([
            'type' => TypeEnum::RECIPIENT,
            'country' => $country
        ]);
        return $this->fetcher->getList($name, $id, $filter);
    }

    /**
     * @return array
     */
    public function getTableColumns(): array
    {
        return $this->fetcher->getTableColumns();
    }

    /**
     * @param array $filter
     * @return array
     */
    private function permissionFilters($filter = []): array
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $filter['company_id'] = $this->security->getUser()->getCompany();
        }

        return $filter;
    }
}
