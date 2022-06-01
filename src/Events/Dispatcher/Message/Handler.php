<?php

declare(strict_types=1);


namespace App\Events\Dispatcher\Message;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class Handler
 * @package App\Events\Dispatcher\Message
 */
class Handler implements MessageHandlerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $dispatcher;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $registry;

    /**
     * Handler constructor.
     *
     * @param ManagerRegistry $registry
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ManagerRegistry $registry, EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->registry = $registry;
    }

    /**
     * @param Message $message
     */
    public function __invoke(Message $message): void
    {
        foreach ($this->registry->getManagers() as $manager) {
            $manager->clear();
        }

        $this->dispatcher->dispatch($message->getEvent());
    }
}
