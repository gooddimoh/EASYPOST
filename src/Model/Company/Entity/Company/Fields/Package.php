<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Package
 * @package App\Model\Company\Entity\Company\Fields
 * @ORM\Embeddable
 */
class Package
{
    /**
     * @var string|null
     * @ORM\Column(type="guid", name="company_package_id", nullable=true)
     */
    private ?string $id;

    /**
     * Package constructor.
     * @param string|null $id
     */
    public function __construct(?string $id)
    {
        $this->id = $id ? $id : null;
    }

    /**
     * @param Package $package
     * @return bool
     */
    public function isEqual(self $package): bool
    {
        return $this->id === $package->getId();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
