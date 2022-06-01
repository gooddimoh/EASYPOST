<?php

declare(strict_types=1);


namespace App\Infrastructure\Events;

/**
 * Interface EventDispatcherInterface
 * @package App\Infrastructure\Events
 */
interface EventDispatcherInterface
{
    /**
     * @param array $events
     */
    public function dispatch(array $events): void;
}