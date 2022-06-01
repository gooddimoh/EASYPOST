<?php

declare(strict_types=1);

namespace App\Model\Company\Entity\Company\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Photo
 * @package App\Model\Company\Entity\Company\Fields
 * @ORM\Embeddable
 */
class Photo
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * Photo constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::maxLength($value, 255, 'Photo must not be longer than 255 characters');

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param self $photo
     * @return bool
     */
    public function isEqual(self $photo): bool
    {
        return $this->getValue() === $photo->getValue();
    }
}
