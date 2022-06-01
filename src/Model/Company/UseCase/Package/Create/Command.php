<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Package\Create;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Company\UseCase\Package\Create
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $name;

    /**
     * @var int
     * @Assert\NotNull()
     */
    public int $priceMonth;

    /**
     * @var int
     * @Assert\NotNull()
     */
    public int $priceLabel;

    /**
     * @var int
     * @Assert\NotNull()
     */
    public int $priceAdditional;

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
    public ?string $availableCompany = null;

    /**
     * @var array
     */
    public array $permissions = [];
}
