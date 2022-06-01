<?php

declare(strict_types=1);


namespace App\ReadModels\AddressBook;

/**
 * Class AddressBookFilter
 * @package App\ReadModels\AddressBook
 */
class AddressBookFilter
{
    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var string|null
     */
    public ?string $phone = null;

    /**
     * @var string|null
     */
    public ?string $email = null;

    /**
     * @var string|null
     */
    public ?string $street1 = null;

    /**
     * @var string|null
     */
    public ?string $street2 = null;

    /**
     * @var string|null
     */
    public ?string $city = null;

    /**
     * @var string|null
     */
    public ?string $state = null;

    /**
     * @var string|null
     */
    public ?string $country = null;

    /**
     * @var string|null
     */
    public ?string $zip = null;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var array|null
     */
    public ?array $status = null;

    /**
     * @var string|null
     */
    public ?string $date = null;

    /**
     * @var string|null
     */
    public ?string $type = null;

    /**
     * @var string|null
     */
    public ?string $companyId = null;

    /**
     * @var string|null
     */
    public ?string $userId = null;
}
