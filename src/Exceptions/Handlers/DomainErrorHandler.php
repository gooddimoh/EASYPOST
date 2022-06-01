<?php

declare(strict_types=1);


namespace App\Exceptions\Handlers;

use Psr\Log\LoggerInterface;

/**
 * Class DomainErrorHandler
 * @package App\Exceptions\Handlers
 */
class DomainErrorHandler
{
    private $logger;

    /**
     * DomainErrorHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \DomainException $e
     */
    public function handle(\DomainException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
