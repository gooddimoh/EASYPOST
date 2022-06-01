<?php

declare(strict_types=1);

namespace App\Model\Company\UseCase\Company\LinkPackage;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements DataObject
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $package;

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
}
