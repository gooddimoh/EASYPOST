<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Creator
 * @package App\Model\User\Entity\User\Fields
 * @ORM\Embeddable
 */
class Creator
{
    /**
     * @var string|null
     * @ORM\Column(type="guid", name="user_user_id", nullable=true)
     */
    private ?string $user;

    /**
     * Creator constructor.
     * @param string|null $user
     */
    public function __construct(?string $user)
    {
        $this->user = $user ? $user : null;
    }

    /**
     * @return string
     */
    public function getUser(): ?string
    {
        return $this->user;
    }
}
