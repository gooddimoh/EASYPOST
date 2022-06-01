<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Social\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SocialId
 *
 * @package App\Model\User\Entity\Social\Fields
 * @ORM\Embeddable
 */
class SocialId
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * SocialId constructor.
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
