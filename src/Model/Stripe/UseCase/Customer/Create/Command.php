<?php

declare(strict_types=1);

namespace App\Model\Stripe\UseCase\Customer\Create;

use App\Infrastructure\ObjectResolver\DataObject;

/**
 * Class Command
 *
 * @package App\Model\Stripe\UseCase\Customer\Create
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
    public string $stripeCustomerId;

    /**
     * @var string
     */
    public string $bankAccountToken;

    /**
     * @var int
     */
    public int $type;

    /**
     * @var int
     */
    public int $status;
}
