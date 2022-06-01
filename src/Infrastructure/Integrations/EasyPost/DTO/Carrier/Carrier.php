<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\EasyPost\DTO\Carrier;

/**
 * Class Carrier
 *
 * @package App\Infrastructure\Integrations\EasyPost\DTO\Carrier
 */
abstract class Carrier
{
    /**
     * @var string
     */
    protected string $description;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @return array
     */
    abstract public function getCredentials(): array;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}