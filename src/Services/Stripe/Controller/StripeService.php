<?php

declare(strict_types=1);

namespace App\Services\Stripe\Controller;

use App\Infrastructure\Enums\Model\Stripe\Customer\TypeEnum;
use App\ReadModels\Stripe\StripeCustomerFetcher;
use Doctrine\DBAL\Driver\Exception;

/**
 * Class StripeService
 *
 * @package App\Services\Stripe\Controller
 */
class StripeService
{
    /**
     * @var StripeCustomerFetcher
     */
    private StripeCustomerFetcher $fetcher;

    /**
     * @param StripeCustomerFetcher $fetcher
     */
    public function __construct(StripeCustomerFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @param string $userId
     * @param int    $type
     *
     * @return array
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getStripeCustomerByUser(string $userId, int $type = TypeEnum::PLAID): array
    {
        return $this->fetcher->getStripeCustomerByUser($userId, $type);
    }
}
