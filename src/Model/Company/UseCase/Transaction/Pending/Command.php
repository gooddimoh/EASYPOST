<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Transaction\Pending;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Company\UseCase\Transaction\Pending
 */
class Command implements DataObject
{
    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $balance;

    /**
     * @var string|null
     */
    public ?string $company = null;

    /**
     * @var string
     */
    public string $description = '';

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $method;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedCompany;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedId;

    /**
     * @var array
     */
    public array $options = [];
}
