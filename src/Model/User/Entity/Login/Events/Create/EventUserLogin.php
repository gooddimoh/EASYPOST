<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Login\Events\Create;

use App\Infrastructure\Events\EventDomainInterface;
use DateTimeImmutable;

/**
 * Class EventUserLogin
 * @package App\Model\User\Entity\Login\Events\Create
 */
class EventUserLogin implements EventDomainInterface
{
    /**
     * @var string
     */
    private string $sessionId;

    /**
     * @var string
     */
    private string $modifiedId;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $date;

    /**
     * @var string
     */
    private string $module;

    /**
     * @var string
     */
    private string $event;

    /**
     * EventUserLogin constructor.
     * @param string $sessionId
     */
    public function __construct(string $sessionId)
    {
        $classArr = explode('\\', get_called_class());

        $this->sessionId = $sessionId;
        $this->module = $classArr[4] ?? '';
        $this->event = $classArr[7] ?? '';
    }

    /**
     * @param string $modifiedId
     */
    public function setUser(string $modifiedId): void
    {
        $this->modifiedId = $modifiedId;
    }

    /**
     * @param DateTimeImmutable $dateTimeImmutable
     */
    public function setDate(DateTimeImmutable $dateTimeImmutable): void
    {
        $this->date = $dateTimeImmutable;
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function getModifiedId(): string
    {
        return $this->modifiedId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }
}
