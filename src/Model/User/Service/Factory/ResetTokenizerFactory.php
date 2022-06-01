<?php

declare(strict_types=1);


namespace App\Model\User\Service\Factory;

use App\Model\User\Service\ResetTokenizer;
use DateInterval;

/**
 * Class ResetTokenizerFactory
 * @package App\Model\User\Service\Factory
 */
class ResetTokenizerFactory
{
    /**
     * @param string $interval
     * @return ResetTokenizer
     * @throws \Exception
     */
    public function create(string $interval): ResetTokenizer
    {
        return new ResetTokenizer(new DateInterval($interval));
    }
}
