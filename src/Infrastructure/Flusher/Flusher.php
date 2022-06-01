<?php

declare(strict_types=1);


namespace App\Infrastructure\Flusher;

use App\Infrastructure\Events\AggregateRoot;
use App\Infrastructure\Events\EventDispatcherInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Flusher
 * @package App\Infrastructure\Flusher
 */
class Flusher implements FlusherInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var array
     */
    private array $waitModels;

    /**
     * Flusher constructor.
     * @param EntityManagerInterface $em
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->waitModels = [];
    }

    /**
     * @param AggregateRoot ...$roots
     */
    public function flush(AggregateRoot ...$roots): void
    {
        $this->em->flush();

        $this->waitModels = [
            ...$this->waitModels,
            ...$roots
        ];
    }

    public function dispatchEvents(): void
    {
        foreach ($this->waitModels as $root) {
            $this->dispatcher->dispatch($root->releaseEvents());
        }

        $this->waitModels = [];
    }
}
