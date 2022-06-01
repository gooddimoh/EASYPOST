<?php

declare(strict_types=1);

namespace App\ReadModels\User\Login;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

/**
 * Class LoginFetcher
 * @package App\ReadModels\User\Login
 */
final class LoginFetcher
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * LoginFetcher constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $sessionId
     * @return array
     * @throws Exception
     */
    public function getBySession(string $sessionId): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'l.session_value as session_id',
                'l.ip_address_value as ip_address',
                'l.browser_value as browser',
                'l.country_value as country',
                'l.city_value as city',
                'l.date as date',
            ])
            ->from('user_user_login', 'l')
            ->andWhere("l.session_value = :session")
            ->setParameter(":session", $sessionId)
            ->setMaxResults(1)
            ->execute();

        if (!$response = $stmt->fetch()) {
            $response = [];
        }

        return $response;
    }

    /**
     * @param string $userId
     * @return bool
     * @throws Exception
     */
    public function exist(string $userId): bool
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                't.id as id',
            ])
            ->from('user_user_login', 't')
            ->andWhere("user_id_value = :user_id")
            ->setParameter(":user_id", $userId)
            ->execute();

        if (!$response = $stmt->fetch()) {
            return false;
        }

        return true;
    }
}
