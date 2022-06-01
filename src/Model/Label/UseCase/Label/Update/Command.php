<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\Update;

use App\Infrastructure\ObjectResolver\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\Model\Label\UseCase\Label\Update
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
    public string $pickupId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $pickupRateId;

    /**
     * @var int
     */
    public int $pickupRatePrice;
}
