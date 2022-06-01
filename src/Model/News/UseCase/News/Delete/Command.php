<?php

declare(strict_types=1);

namespace App\Model\News\UseCase\News\Delete;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

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
