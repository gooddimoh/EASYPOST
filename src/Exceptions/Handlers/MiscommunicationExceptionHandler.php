<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use App\Infrastructure\Exceptions\MiscommunicationException;
use Psr\Log\LoggerInterface;

/**
 * Class MiscommunicationExceptionHandler
 *
 * @package App\Exceptions\Handlers
 */
class MiscommunicationExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * MiscommunicationExceptionHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param MiscommunicationException $e
     */
    public function handle(MiscommunicationException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
