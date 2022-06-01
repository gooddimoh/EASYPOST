<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Transaction\Update;

use App\Infrastructure\ObjectResolver\DataObject;

/**
 * Class Command
 *
 * @package App\Model\Company\UseCase\Transaction\Update
 */
class Command implements DataObject
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var int
     */
    public int $status;
}
