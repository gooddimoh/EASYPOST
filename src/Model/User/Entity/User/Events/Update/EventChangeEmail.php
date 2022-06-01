<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Events\Update;

use App\Infrastructure\Events\EventDomainInterface;
use App\Model\User\Entity\User\Fields\{Email, Id};
use DateTimeImmutable;

/**
 * Class EventChangeName
 * @package App\Model\User\Entity\User\Events\Update
 */
class EventChangeEmail implements EventDomainInterface
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var Email
     */
    private Email $oldValue;

    /**
     * @var Email
     */
    private Email $newValue;

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
     * EventChangeName constructor.
     * @param Id $id
     * @param Email $oldValue
     * @param Email $newValue
     */
    public function __construct(Id $id, Email $oldValue, Email $newValue)
    {
        $classArr = explode('\\', get_called_class());

        $this->id = $id;
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
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
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Email
     */
    public function getOldValue(): Email
    {
        return $this->oldValue;
    }

    /**
     * @return Email
     */
    public function getNewValue(): Email
    {
        return $this->newValue;
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
