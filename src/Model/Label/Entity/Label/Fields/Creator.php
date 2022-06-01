<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Creator
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Creator
{
    /**
     * @var string|null
     * @ORM\Column(type="guid", name="user_user_id", nullable=false)
     */
    private string $user;

    /**
     * @var string|null
     * @ORM\Column(type="guid", name="company_company_id", nullable=false)
     */
    private string $company;

    /**
     * Creator constructor.
     * @param string $user
     * @param string $company
     */
    public function __construct(string $user, string $company)
    {
        $this->user = $user;
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }
}