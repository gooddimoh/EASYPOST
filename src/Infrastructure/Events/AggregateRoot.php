<?php

declare(strict_types=1);


namespace App\Infrastructure\Events;

use DateTimeImmutable;

/**
 * Interface AggregateRoot
 * @package App\Infrastructure\Events
 */
abstract class AggregateRoot
{
    /**
     * @var array
     */
    protected array $recordedEvents = [];

    /**
     * @param EventDomainInterface $event
     */
    protected function recordEvent(EventDomainInterface $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /**
     * @return array
     */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;

        $this->recordedEvents = [];

        return $events;
    }

    /**
     * @param string $userId
     * @throws \Exception
     */
    public function recordEventUser(string $userId)
    {
        /**
         * @var EventDomainInterface $event
         */
        foreach ($this->recordedEvents as $event) {
            $event->setUser($userId);
            $event->setDate(new DateTimeImmutable());
        }
    }
}
