<?php

declare(strict_types=1);

namespace App\ReadModels\Stripe;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

/**
 * Class StripeCustomerFetcher
 *
 * @package App\ReadModels\Stripe
 */
class StripeCustomerFetcher
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $userId
     * @param int    $type
     *
     * @return array
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getStripeCustomerByUser(string $userId, int $type): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                [
                    's.id as id',
                    's.user_id AS user_id',
                    's.stripe_id_value AS stripe_id',
                    's.bank_account_token_value AS bank_account_token',
                    's.type_value AS type',
                    's.status_value AS status',
                ]
            )
            ->from('stripe_customers', 's');

        $stmt->andWhere("s.user_id = :user_id");
        $stmt->andWhere("s.type_value = :type");

        $stmt->setParameter(":user_id", $userId);
        $stmt->setParameter(":type", $type);

        $stmt-> 
        $customer = $stmt->execute()->fetchAssociative();

        return $customer ?: [];
    }
}
