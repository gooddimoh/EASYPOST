<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Carrier\Ups\Update;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Label\UseCase\Carrier\Ups\Update
 */
class Command implements DataObject
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $accessLicenseNumber;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $accountNumber;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedCompany;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $modifiedId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $password;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $userId;
}
