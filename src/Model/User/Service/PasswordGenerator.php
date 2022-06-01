<?php

declare(strict_types=1);

namespace App\Model\User\Service;

/**
 * Class PasswordGenerator
 * @package App\Model\User\Service
 */
class PasswordGenerator
{
    /**
     * @param int $length
     * @return string
     */
    public function generate(int $length = 8): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}