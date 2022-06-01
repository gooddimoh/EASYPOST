<?php

declare(strict_types=1);

namespace App\Model\News\Entity\News;

use App\Infrastructure\Events\AggregateRoot;
use App\Model\News\Entity\News\Fields\{Title, Id, Description, Photo, Creator, Link, Status};
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use DateTimeImmutable;

/**
 * Class News
 *
 * @package App\Model\News\Entity\News
 *
 * @ORM\Entity
 * @ORM\Table(name="news_news")
 */
class News extends AggregateRoot
{
    /**
     * @var Id
     * @ORM\Column(type="news_news_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @var Title
     * @ORM\Embedded(class="App\Model\News\Entity\News\Fields\Title")
     */
    private Title $title;

    /**
     * @var Photo
     * @ORM\Embedded(class="App\Model\News\Entity\News\Fields\Photo")
     */
    private Photo $photo;

    /**
     * @var Description
     * @ORM\Embedded(class="App\Model\News\Entity\News\Fields\Description")
     */
    private Description $description;

    /**
     * @var Link
     * @ORM\Embedded(class="App\Model\News\Entity\News\Fields\Link")
     */
    private Link $link;

    /**
     * @var Status
     * @ORM\Embedded(class="App\Model\News\Entity\News\Fields\Status")
     */
    private Status $status;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @var Creator
     * @ORM\Embedded(class="App\Model\News\Entity\News\Fields\Creator", columnPrefix=false)
     */
    private Creator $user;

    /**
     * @param Id                $id
     * @param Title             $title
     * @param Photo             $photo
     * @param Description       $description
     * @param Link              $link
     * @param Creator           $creator
     * @param DateTimeImmutable $date
     * @param Status            $status
     */
    public function __construct(
        Id                $id,
        Title             $title,
        Photo             $photo,
        Description       $description,
        Link              $link,
        Creator           $creator,
        DateTimeImmutable $date,
        Status            $status
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->photo = $photo;
        $this->description = $description;
        $this->link = $link;
        $this->status = $status;
        $this->user = $creator;
        $this->date = $date;
    }

    /**
     * @param Title $title
     */
    public function changeTitle(Title $title): void
    {
        if ($this->title->isEqual($title)) {
            return;
        }

        $this->title = $title;
    }

    /**
     * @param Photo $photo
     */
    public function changePhoto(Photo $photo): void
    {
        if ($this->photo->isEqual($photo)) {
            return;
        }

        $this->photo = $photo;
    }

    /**
     * @param Description $description
     */
    public function changeDescription(Description $description): void
    {
        if ($this->description->isEqual($description)) {
            return;
        }

        $this->description = $description;
    }

    /**
     * @param Status $status
     */
    public function changeStatus(Status $status): void
    {
        $this->status = $status;
    }

    /**
     * @param Link $link
     */
    public function changeLink(Link $link): void
    {
        if ($this->link->isEqual($link)) {
            return;
        }

        $this->link = $link;
    }

    /**
     * @param DateTimeImmutable $date
     */
    public function changeDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function delete(): void
    {
        if ($this->isBlocked()) {
            throw new DomainException('News is already deleted.');
        }

        $this->changeStatus(Status::block());
    }

    /**
     * @param News $news
     *
     * @return bool
     */
    public function isEqual(News $news): bool
    {
        return $this->getId()->getValue() === $news->getId()->getValue();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->status->isBlocked();
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Photo
     */
    public function getPhoto(): Photo
    {
        return $this->photo;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return Link
     */
    public function getLink(): Link
    {
        return $this->link;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Creator
     */
    public function getUser(): Creator
    {
        return $this->user;
    }
}
