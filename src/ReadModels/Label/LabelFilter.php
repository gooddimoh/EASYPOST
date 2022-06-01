<?php

declare(strict_types=1);


namespace App\ReadModels\Label;

/**
 * Class AddressBookFilter
 *
 * @package App\ReadModels\AddressBook
 */
class LabelFilter
{
    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var string|null
     */
    public ?string $sender = null;

    /**
     * @var string|null
     */
    public ?string $recipient = null;

    /**
     * @var string|null
     */
    public ?string $date = null;

    /**
     * @var string|null
     */
    public ?string $weight = null;

    /**
     * @var string|null
     */
    public ?string $price = null;

    /**
     * @var string|null
     */
    public ?string $pickupPrice = null;

    /**
     * @var string|null
     */
    public ?string $service = null;

    /**
     * @var string|null
     */
    public ?string $carrier = null;

    /**
     * @var array|null
     */
    public ?array $status = null;

    /**
     * @var string|null
     */
    public ?string $track = null;

    /**
     * @var string|null
     */
    public ?string $companyId = null;

    /**
     * @var string|null
     */
    public ?string $userId = null;

    /**
     * @var string|null
     */
    public ?string $dateFrom = null;

    /**
     * @var string|null
     */
    public ?string $dateTo = null;

    /**
     * @var string|null
     */
    public ?string $name = null;
}
