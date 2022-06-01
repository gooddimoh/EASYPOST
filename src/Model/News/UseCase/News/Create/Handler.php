<?php

declare(strict_types=1);

namespace App\Model\News\UseCase\News\Create;

use App\Model\News\Entity\News\News;
use App\Model\News\Repositories\News\NewsRepositoryInterface;
use App\Model\News\Entity\News\Fields\{Creator, Title, Id, Photo, Status, Description, Link};
use App\Infrastructure\Flusher\FlusherInterface;
use DateTimeImmutable;
use Exception;

class Handler
{
    /**
     * @var NewsRepositoryInterface
     */
    private NewsRepositoryInterface $newsRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @param NewsRepositoryInterface $newsRepository
     * @param FlusherInterface        $flusher
     */
    public function __construct(
        NewsRepositoryInterface $newsRepository,
        FlusherInterface        $flusher
    ) {
        $this->flusher = $flusher;
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param Command $command
     *
     * @return News
     * @throws Exception
     */
    public function handle(Command $command): News
    {
        $news = new News(
            Id::next(),
            new Title($command->title),
            new Photo($command->photo),
            new Description($command->description),
            new Link($command->link),
            new Creator($command->modifiedId, $command->modifiedCompany),
            new DateTimeImmutable(),
            Status::active(),
        );

        $this->newsRepository->add($news);
        $this->flusher->flush();

        return $news;
    }
}
