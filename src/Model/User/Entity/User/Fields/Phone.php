<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;
use Exception;

/**
 * Class Phone
 * @package App\Model\User\Entity\User\Fields
 * @ORM\Embeddable
 */
class Phone
{
    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private string $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private string $number;

    /**
     * Phone constructor.
     * @param string $code
     * @param string $number
     * @throws Exception
     */
    public function __construct(string $code, string $number)
    {
        Assert::maxLength($code, 10, 'Code must not be longer than 10 characters');
        Assert::maxLength($number, 20, 'Number must not be longer than 20 characters');

        $this->code = $code;
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getFullNumber(): string
    {
        return $this->code . $this->number;
    }

    /**
     * @param self $phone
     * @return bool
     */
    public function isEqual(self $phone): bool
    {
        return $this->code === $phone->getCode() && $this->number === $phone->getNumber();
    }
}
