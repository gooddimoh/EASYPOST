<?php

declare(strict_types=1);


namespace App\Events\Dispatcher;

use App\Events\Dispatcher\Message\Message;
use App\Infrastructure\Events\EventDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerEventDispatcher
 * @package App\Events\Dispatcher
 */
class MessengerEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * MessengerEventDispatcher constructor.
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param array $events
     */
    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->bus->dispatch(new Message($event));
        }
    }
}