<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Events\Update;

use App\Infrastructure\Events\EventDomainInterface;
use App\Model\User\Entity\User\Fields\{Id, Name};
use DateTimeImmutable;

/**
 * Class EventChangeName
 * @package App\Model\User\Entity\User\Events\Update
 */
class EventChangeName implements EventDomainInterface
{
    private $id;
    private $oldValue;
    private $newValue;
    private $modifiedId;
    private $date;
    private $module;
    private $event;

    /**
     * EventChangeName constructor.
     * @param Id $id
     * @param Name $oldValue
     * @param Name $newValue
     */
    public function __construct(Id $id, Name $oldValue, Name $newValue)
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
     * @return Name
     */
    public function getOldValue(): Name
    {
        return $this->oldValue;
    }

    /**
     * @return Name
     */
    public function getNewValue(): Name
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