<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Update;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\Company\UseCase\Company\Update
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
    public string $name;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $type;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedId;

    /**
     * @var string
     */
    public string $photo = '';

}
