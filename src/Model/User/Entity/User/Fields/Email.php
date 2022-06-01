<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;
use Exception;

/**
 * Class Email
 * @package App\Model\User\Entity\User\Fields
 * @ORM\Embeddable
 */
class Email
{
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $value;

    /**
     * Email constructor.
     * @param string $email
     * @throws Exception
     */
    public function __construct(string $email)
    {
        Assert::notEmpty($email);
        Assert::email($email);
        Assert::maxLength($email, 50, 'Email must not be longer than 50 characters');

        $this->value = $email;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param self $email
     * @return bool
     */
    public function isEqual(self $email): bool
    {
        return $this->getValue() === $email->getValue();
    }
}
