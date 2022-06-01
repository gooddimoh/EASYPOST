<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\Draft\Delete;

use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Label\Entity\Label\Fields\Id;
use App\Model\Label\Repositories\Label\LabelRepositoryInterface;
use Exception;

class Handler
{
    /**
     * @var LabelRepositoryInterface
     */
    private LabelRepositoryInterface $labelRepository;

    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     *
     * @param LabelRepositoryInterface $labelRepository
     * @param FlusherInterface         $flusher
     */
    public function __construct(
        LabelRepositoryInterface $labelRepository,
        FlusherInterface         $flusher
    ) {
        $this->flusher = $flusher;
        $this->labelRepository = $labelRepository;
    }

    /**
     * @param Command $command
     *
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        $label = $this->labelRepository->get(new Id($command->id));
        $label->block();

        $this->labelRepository->add($label);

        $this->flusher->flush($label);
    }
}
