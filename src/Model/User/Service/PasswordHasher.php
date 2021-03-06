<?php

declare(strict_types=1);

namespace App\Model\User\Service;

/**
 * Class PasswordHasher
 * @package App\Model\User\Service
 */
class PasswordHasher
{
    /**
     * @param string $password
     * @return string
     */
    public function hash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_ARGON2I);

        if (!$hash) {
            throw new \RuntimeException('Unable to generate hash.');
        }

        return $hash;
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
