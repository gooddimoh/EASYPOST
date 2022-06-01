<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Create;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Company\UseCase\Company\Create
 */
class Command implements DataObject
{
    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $type;

    /**
     * @var string|null
     */
    public ?string $package= null;

    /**
     * @var string|null
     */
    public ?string $modifiedId = null;

    /**
     * @var string|null
     */
    public ?string $modifiedCompany = null;

    /**
     * @var string
     */
    public string $photo = '';

    /**
     * @var string|null
     */
    public ?string $name = null;
}
