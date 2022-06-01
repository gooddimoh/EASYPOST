<?php

declare(strict_types=1);

namespace App\Infrastructure\Dispatcher;

/**
 * Interface DispatcherInterface
 * @package App\Infrastructure\Dispatcher
 */
interface DispatcherInterface
{
    /**
     * @param array $events
     */
    public function releaseEvents(array $events): void;
}