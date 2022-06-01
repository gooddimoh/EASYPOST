<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Infrastructure\Services\TokenGenerator;

/**
 * Class NewEmailConfirmTokenizer
 * @package App\Model\User\Service
 */
class NewEmailConfirmTokenizer
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string
    {
        return TokenGenerator::generate();
    }
}
