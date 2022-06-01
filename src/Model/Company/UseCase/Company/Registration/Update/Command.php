<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\Registration\Update;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements DataObject
{
    /**
     * @var string
     */
    public string $companyId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $companyName;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public int $companyType;
}
