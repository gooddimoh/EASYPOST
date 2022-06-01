<?php

declare(strict_types=1);


namespace App\Infrastructure\Services;

use Ramsey\Uuid\Uuid;

/**
 * Class UuidGenerator
 * @package App\Infrastructure\Services
 */
class TokenGenerator
{
    /**
     * @return string
     * @throws \Exception
     */
    static public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}