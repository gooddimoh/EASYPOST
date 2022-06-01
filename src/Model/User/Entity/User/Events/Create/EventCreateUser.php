<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Events\Create;

use App\Infrastructure\Events\EventDomainInterface;
use App\Model\User\Entity\User\User;
use DateTimeImmutable;

/**
 * Class EventCreateUser
 * @package App\Model\User\Entity\User\Events\Create
 */
class EventCreateUser implements EventDomainInterface
{
    /**
     * @var User
     */
    private User $user;

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
     * EventCreateUser constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $classArr = explode('\\', get_called_class());

        $this->user = $user;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
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
