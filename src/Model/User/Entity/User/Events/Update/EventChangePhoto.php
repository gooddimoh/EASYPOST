<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Events\Update;

use App\Infrastructure\Events\EventDomainInterface;
use App\Model\User\Entity\User\Fields\{Photo, Id};
use DateTimeImmutable;

/**
 * Class EventChangeName
 * @package App\Model\User\Entity\User\Events\Update
 */
class EventChangePhoto implements EventDomainInterface
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
     * @param Photo $oldValue
     * @param Photo $newValue
     */
    public function __construct(Id $id, Photo $oldValue, Photo $newValue)
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
     * @return Photo
     */
    public function getOldValue(): Photo
    {
        return $this->oldValue;
    }

    /**
     * @return Photo
     */
    public function getNewValue(): Photo
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