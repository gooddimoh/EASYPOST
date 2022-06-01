<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Carrier\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Creator
 *
 * @package App\Model\Label\Entity\Carrier\Fields
 * @ORM\Embeddable
 */
class Creator
{
    /**
     * @var string
     * @ORM\Column(type="guid", name="company_company_id", nullable=false)
     */
    private string $company;

    /**
     * @var string
     * @ORM\Column(type="guid", name="user_user_id", nullable=false)
     */
    private string $user;

    /**
     * Creator constructor.
     *
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
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }
}
