<?php

declare(strict_types=1);

namespace App\ReadModels\User\Social;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class SocialFetcher
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
     * @param string $socialId
     * @param int    $type
     *
     * @return array
     * @throws Exception
     */
    public function findBySocialId(string $socialId, int $type): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                's.id as id',
                's.user_user_id as user_id',
                's.social_id_value as social_id',
                's.type_value as type',
                's.date as date',
            ])
            ->from('user_user_socials', 's')
            ->andWhere("s.social_id_value = :social_id")
            ->andWhere("s.type_value = :type")
            ->setParameter(":social_id", $socialId)
            ->setParameter(":type", $type)
            ->setMaxResults(1)
            ->execute();

        if (!$response = $stmt->fetch()) {
            $response = [];
        }

        return $response;
    }
}
