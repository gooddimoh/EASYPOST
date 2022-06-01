<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Delete;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\Company\UseCase\Company\Delete
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedId;
}
