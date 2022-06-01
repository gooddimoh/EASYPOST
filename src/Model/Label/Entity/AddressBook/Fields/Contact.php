<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\AddressBook\Fields;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 * @package App\Model\Label\Entity\AddressBook\Fields
 * @ORM\Embeddable
 */
class Contact
{
    /**
     * @var string|null
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private ?string $code;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private ?string $phone;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $email;

    /**
     * Contact constructor.
     * @param string|null $code
     * @param string|null $phone
     * @param string|null $email
     */
    public function __construct(?string $code, ?string $phone, ?string $email)
    {
        $this->code = $code ? $code : null;
        $this->phone = $phone ? $phone : null;
        $this->email = $email ? $email : null;
    }

    /**
     * @param self $name
     * @return bool
     */
    public function isEqual(self $name): bool
    {
        return $this->phone === $name->getPhone() &&
            $this->email === $name->getEmail() &&
            $this->code === $name->getCode();
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }
}
