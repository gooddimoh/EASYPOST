<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Social\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @package App\Model\User\Entity\Social\Fields
 * @ORM\Embeddable
 */
class User
{
    /**
     * @var string
     * @ORM\Column(type="guid", name="user_id", nullable=false)
     */
    private string $value;

    /**
     * User constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
