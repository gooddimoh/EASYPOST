<?php

declare(strict_types=1);

namespace App\Model\News\UseCase\News\Update;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\News\Entity\News\Fields\Description;
use App\Model\News\Entity\News\Fields\Id;
use App\Model\News\Entity\News\Fields\Link;
use App\Model\News\Entity\News\Fields\Photo;
use App\Model\News\Entity\News\Fields\Title;
use App\Model\News\Entity\News\News;
use App\Model\News\Repositories\News\NewsRepositoryInterface;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Company\Update
 */
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
     * @throws \Exception
     */
    public function handle(Command $command): News
    {
        $news = $this->newsRepository->get(new Id($command->id));

        $news->changeTitle(new Title($command->title));
        $news->changePhoto(new Photo($command->photo));
        $news->changeDescription(new Description($command->description));
        $news->changeLink(new Link($command->link));

        $this->flusher->flush();

        return $news;
    }
}
