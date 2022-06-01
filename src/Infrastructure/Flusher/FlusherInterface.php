<?php

declare(strict_types=1);


namespace App\Infrastructure\Flusher;

use App\Infrastructure\Events\AggregateRoot;

/**
 * Interface FlusherInterface
 * @package App\Infrastructure\Flusher
 */
interface FlusherInterface
{
    /**
     * @param AggregateRoot ...$roots
     */
    public function flush(AggregateRoot ...$roots): void;

    public function dispatchEvents(): void;
}
