<?php

declare(strict_types=1);

namespace App\ModelServices;

use App\Infrastructure\Enums\Model\Company\TypeEnum;
use App\Infrastructure\Enums\Model\User\RoleEnum;
use App\Model\User\UseCase\User\Create as UserCreate;
use App\Model\Company\UseCase\Company\Create as CompanyCreate;
use App\Model\User\Entity\User\User;

class FirstRegistrationHandler
{
    /**
     * @var UserCreate\Handler
     */
    private UserCreate\Handler $userHandler;

    /**
     * @var CompanyCreate\Handler
     */
    private CompanyCreate\Handler $companyHandler;

    /**
     * @param UserCreate\Handler    $handler
     * @param CompanyCreate\Handler $companyHandler
     */
    public function __construct(UserCreate\Handler $handler, CompanyCreate\Handler $companyHandler)
    {
        $this->userHandler = $handler;
        $this->companyHandler = $companyHandler;
    }

    /**
     * @param UserCreate\Command $userCommand
     *
     * @return User
     * @throws \Exception
     */
    public function handle(UserCreate\Command $userCommand): User
    {
        $companyCommand = new CompanyCreate\Command();

        $companyCommand->type = TypeEnum::SINGLE_PERSON;
        $companyCommand->modifiedId = $userCommand->modifiedId;

        $company = $this->companyHandler->handle($companyCommand);

        $userCommand->company = $company->getId()->getValue();
        $userCommand->role = RoleEnum::OWNER;

        return $this->userHandler->handle($userCommand);
    }
}
