<?php

declare(strict_types=1);

namespace App\Model\News\Entity\News\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Title
 *
 * @package App\Model\News\Entity\News\Fields
 * @ORM\Embeddable
 */
class Title
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::maxLength($value, 255, 'Title must not be longer than 255 characters');

        $this->value = $value;
    }

    /**
     * @param Title $title
     *
     * @return bool
     */
    public function isEqual(self $title): bool
    {
        return $this->value === $title->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
