<?php

declare(strict_types=1);

namespace App\Model\News\UseCase\News\Delete;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\News\Entity\News\Fields\Id;
use App\Model\News\Entity\News\Fields\Status;
use App\Model\News\Repositories\News\NewsRepositoryInterface;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Company\UseCase\Company\Delete
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
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        $news = $this->newsRepository->get(new Id($command->id));
        $news->changeStatus(Status::block());

        $this->flusher->flush();
    }
}
