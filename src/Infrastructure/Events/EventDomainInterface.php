<?php

declare(strict_types=1);

namespace App\Infrastructure\Events;

use DateTimeImmutable;

/**
 * Interface EventDomainInterface
 * @package App\Infrastructure\Events
 */
interface EventDomainInterface
{
    /**
     * @param string $userId
     */
    public function setUser(string $userId): void;

    /**
     * @param DateTimeImmutable $dateTimeImmutable
     */
    public function setDate(DateTimeImmutable $dateTimeImmutable): void;
}