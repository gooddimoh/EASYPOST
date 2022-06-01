<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Login\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserId
 * @package App\Model\User\Entity\Login\Fields
 * @ORM\Embeddable
 */
class User
{
    /**
     * @var string|null
     * @ORM\Column(type="guid", name="user_id", nullable=false)
     */
    private string $value;

    /**
     * UserId constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
