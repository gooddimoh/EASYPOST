<?php

declare(strict_types=1);

namespace App\ModelServices;

use App\Model\User\UseCase\User\Confirm as UserConfirm;
use App\Model\Company\UseCase\Company\Registration\Update as CompanyUpdate;
use App\Model\Label\UseCase\AddressBook\Create as AddressBookCreate;
use App\Model\User\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;

class FullRegistrationHandler
{
    /**
     * @var UserConfirm\Handler
     */
    private UserConfirm\Handler $userHandler;

    /**
     * @var CompanyUpdate\Handler
     */
    private CompanyUpdate\Handler $companyHandler;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var AddressBookCreate\Handler
     */
    private AddressBookCreate\Handler $addressBookHandler;

    /**
     * @param UserConfirm\Handler       $handler
     * @param CompanyUpdate\Handler     $companyHandler
     * @param EntityManagerInterface    $em
     * @param AddressBookCreate\Handler $addressBookHandler
     */
    public function __construct(
        UserConfirm\Handler       $handler,
        CompanyUpdate\Handler     $companyHandler,
        EntityManagerInterface    $em,
        AddressBookCreate\Handler $addressBookHandler
    ) {
        $this->userHandler = $handler;
        $this->companyHandler = $companyHandler;
        $this->em = $em;
        $this->addressBookHandler = $addressBookHandler;
    }

    /**
     * @param UserConfirm\Command       $userCommand
     * @param CompanyUpdate\Command     $companyCommand
     * @param AddressBookCreate\Command $addressBookCommand
     *
     * @return User
     * @throws \Throwable
     */
    public function handle(
        UserConfirm\Command       $userCommand,
        CompanyUpdate\Command     $companyCommand,
        AddressBookCreate\Command $addressBookCommand
    ): User {
        $this->em->beginTransaction();

        try {
            $this->addressBookHandler->handle($addressBookCommand);
            $this->companyHandler->handle($companyCommand);
            $user = $this->userHandler->handle($userCommand);

            $this->em->commit();
        } catch (\Throwable $exception) {
            $this->em->rollback();
            $this->em->clear();

            throw $exception;
        }

        return $user;
    }
}
