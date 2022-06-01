<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Creator
 * @package App\Model\Company\Entity\Company\Fields
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
     * @var string|null
     * @ORM\Column(type="guid", name="company_company_id", nullable=true)
     */
    private ?string $company;

    /**
     * Creator constructor.
     * @param string|null $user
     * @param string|null $company
     */
    public function __construct(?string $user, ?string $company)
    {
        $this->user = $user ? $user : null;
        $this->company = $company ? $company: null;
    }

    /**
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }
}
