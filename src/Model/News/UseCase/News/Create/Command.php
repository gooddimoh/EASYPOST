<?php

declare(strict_types=1);

namespace App\Model\News\UseCase\News\Create;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $description;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $link;

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
     * @var string
     */
    public string $photo = '';
}
