<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Block;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 * @package App\Model\User\UseCase\User\Block
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $id;

    /**
     * Command constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
