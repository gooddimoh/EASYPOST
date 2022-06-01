<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pickup
 *
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Pickup
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $id;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $price;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $rateId;

    /**
     * Pickup constructor.
     *
     * @param string|null $id
     * @param int|null    $price
     * @param string|null $rateId
     */
    public function __construct(?string $id = null, ?int $price = null, ?string $rateId = null)
    {
        $this->id = $id;
        $this->price = $price;
        $this->rateId = $rateId;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @return string|null
     */
    public function getRateId(): ?string
    {
        return $this->rateId;
    }
}
