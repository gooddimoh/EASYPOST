<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Social\Fields;

use App\Infrastructure\Enums\Model\User\SocialEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Type
 *
 * @package App\Model\User\Entity\Social\Fields
 * @ORM\Embeddable
 */
class Type
{
    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     */
    private int $value;

    /**
     * Type constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::oneOf($value, SocialEnum::getAll());

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
