<?php

declare(strict_types=1);

namespace App\Services\Session;

use App\ReadModels\User\Login\LoginFetcher;
use Redis;

/**
 * Class SessionService
 * @package App\Services\Session
 */
class SessionService
{
    /**
     * @var string
     */
    const PREFIX = 'sf_s';

    /**
     * @var int
     */
    const AVAILABLE_SESSIONS = 2;

    /**
     * @var Redis
     */
    private Redis $redis;

    /**
     * @var LoginFetcher
     */
    private LoginFetcher $loginFetcher;

    /**
     * SessionService constructor.
     * @param Redis $redis
     * @param LoginFetcher $loginFetcher
     */
    public function __construct(Redis $redis, LoginFetcher $loginFetcher)
    {
        $this->redis = $redis;
        $this->loginFetcher = $loginFetcher;
    }

    /**
     * @param string $userId
     * @param bool $withData
     * @return array
     */
    public function getUserSessions(string $userId, bool $withData = false): array
    {
        $response = [];
        $keys = $this->redis->keys('*');

        foreach ($keys as $key) {
            if (strpos($this->redis->get($key), $userId)) {
                $sessionId = str_replace(self::PREFIX, '', $key);

                $response[] = $withData ? $this->loginFetcher->getBySession($sessionId) : $sessionId;
            }
        }

        return $response;
    }

    /**
     * @param string $userId
     * @return bool
     */
    public function isUserHaveAvailableSessions(string $userId): bool
    {
        return count($this->getUserSessions($userId)) < self::AVAILABLE_SESSIONS;
    }

    /**
     * @param string $sessionId
     * @return bool
     */
    public function deleteSession(string $sessionId): bool
    {
        return !!$this->redis->del(self::PREFIX . $sessionId);
    }
}
