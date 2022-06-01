<?php

declare(strict_types=1);


namespace App\Events\Dispatcher\Message;

/**
 * Class Message
 * @package App\Events\Dispatcher\Message
 */
class Message
{
    /**
     * @var object
     */
    private $event;

    /**
     * Message constructor.
     * @param object $event
     */
    public function __construct(object $event)
    {
        $this->event = $event;
    }

    /**
     * @return object
     */
    public function getEvent(): object
    {
        return $this->event;
    }
}