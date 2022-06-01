<?php

declare(strict_types=1);

namespace App\Infrastructure\Dispatcher;

use App\Infrastructure\Events\EventDispatcherInterface;

/**
 * Class Dispatcher
 * @package App\Infrastructure\Dispatcher
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Dispatcher constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param array $events
     */
    public function releaseEvents(array $events): void
    {
        $this->dispatcher->dispatch($events);
    }
}