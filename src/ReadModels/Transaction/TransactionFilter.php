<?php

declare(strict_types=1);


namespace App\ReadModels\Transaction;

/**
 * Class CompanyFilter
 *
 * @package App\ReadModels\Company
 */
class TransactionFilter
{
    /**
     * @var string|null
     */
    public ?string $id = null;

    /**
     * @var string|null
     */
    public ?string $balance = null;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var string|null
     */
    public ?string $userName = null;

    /**
     * @var string|null
     */
    public ?string $carrier = null;

    /**
     * @var int|null
     */
    public ?int $type = null;

    /**
     * @var string|null
     */
    public ?string $date = null;

    /**
     * @var string|null
     */
    public ?string $companyId = null;

    /**
     * @var string|null
     */
    public ?string $userId = null;

    /**
     * @var array|null
     */
    public ?array $status = null;

    /**
     * @var string|null
     */
    public ?string $dateFrom = null;

    /**
     * @var string|null
     */
    public ?string $dateTo = null;
}
