<?php

declare(strict_types=1);

namespace App\Model\Stripe\UseCase\Customer\Update;

use App\Infrastructure\ObjectResolver\DataObject;

/**
 * Class Command
 *
 * @package App\Model\Stripe\UseCase\Customer\Update
 */
class Command implements DataObject
{
    /**
     * @var string
     */
    public string $stripeId;

    /**
     * @var int
     */
    public int $status;
}
