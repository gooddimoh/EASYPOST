<?php

declare(strict_types=1);

namespace App\Model\Stripe\UseCase\Charge\Create;

use App\Infrastructure\ObjectResolver\DataObject;

/**
 * Class Command
 *
 * @package App\Model\Stripe\UseCase\Charge\Create
 */
class Command implements DataObject
{
    /**
     * @var string
     */
    public string $userId;

    /**
     * @var string
     */
    public string $companyId;

    /**
     * @var string
     */
    public string $transactionId;

    /**
     * @var string
     */
    public string $customerId;

    /**
     * @var string
     */
    public string $stripeChargeId;

    /**
     * @var int
     */
    public int $amount;

    /**
     * @var array
     */
    public array $data = [];
}
