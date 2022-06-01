<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Transaction\Credit;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Company\UseCase\Transaction\Create
 */
class Command implements DataObject
{
    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $balance;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $method;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedCompany;

    /**
     * @var string|null
     */
    public ?string $company = null;

    /**
     * @var array
     */
    public array $options = [];

    /**
     * @var string
     */
    public string $description = '';
}
