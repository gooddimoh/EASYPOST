<?php

declare(strict_types=1);

namespace App\Model\Label\Entity\Label\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Options
 * @package App\Model\Label\Entity\Label\Fields
 * @ORM\Embeddable
 */
class Options
{

    /**
     * @var array
     * @ORM\Column(type="json", nullable=false)
     */
    private array $value = [];

    /**
     * Options constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->value = $options;
    }

    /**
     * @param self $type
     * @return bool
     */
    public function isEqual(self $type): bool
    {
        return $this->value === $type->getValue();
    }

    /**
     * @param Options $options
     */
    public function merge(self $options): void
    {
        $this->value = array_merge_recursive($options->getValue(), $this->value);
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
