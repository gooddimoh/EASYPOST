<?php

declare(strict_types=1);


namespace App\Exceptions\Handlers;

use App\Infrastructure\Exceptions\BalanceAmountException;
use Psr\Log\LoggerInterface;

/**
 * Class BalanceAmountErrorHandler
 * @package App\Exceptions\Handlers
 */
class BalanceAmountErrorHandler
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
     * @param BalanceAmountException $e
     */
    public function handle(BalanceAmountException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
