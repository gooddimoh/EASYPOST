<?php

declare(strict_types=1);

namespace App\Model\Label\UseCase\Label\Update;

use App\Model\Label\Entity\Label\Label;
use App\Model\Label\Entity\Label\Fields\{Id, Pickup};
use App\Infrastructure\Flusher\FlusherInterface;
use App\Model\Label\Repositories\Label\LabelRepositoryInterface;
use Exception;

/**
 * Class Handler
 *
 * @package App\Model\Label\UseCase\Label\Update
 */
class Handler
{
    /**
     * @var FlusherInterface
     */
    private FlusherInterface $flusher;

    /**
     * @var LabelRepositoryInterface
     */
    private LabelRepositoryInterface $labelRepository;

    /**
     * Handler constructor.
     *
     * @param LabelRepositoryInterface $labelRepository
     * @param FlusherInterface         $flusher
     */
    public function __construct(
        LabelRepositoryInterface $labelRepository,
        FlusherInterface $flusher
    ) {
        $this->flusher = $flusher;
        $this->labelRepository = $labelRepository;
    }

    /**
     * @param Command $command
     *
     * @return Label
     * @throws Exception
     */
    public function handle(Command $command): Label
    {
        $label = $this->labelRepository->get(new Id($command->id));

        $label->changePickup(
            new Pickup(
                $command->pickupId,
                $command->pickupRatePrice,
                $command->pickupRateId
            )
        );

        $this->flusher->flush($label);

        return $label;
    }
}
