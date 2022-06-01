<?php

declare(strict_types=1);

namespace App\Infrastructure\Enums\Model\Company;

/**
 * Class TypeEnum
 *
 * @package App\Infrastructure\Enums\Model\Company
 */
final class TypeEnum
{
    const COMPANY = 1;
    const SINGLE_PERSON = 2;

    /**
     * @var array
     */
    const TYPE_NAME = [
        self::COMPANY => 'ROLE_COMPANY',
        self::SINGLE_PERSON => 'ROLE_SINGLE_PERSON',
    ];

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::COMPANY,
            self::SINGLE_PERSON,
        ];
    }

    /**
     * @param $companyType
     *
     * @return string
     */
    public static function getCompanyTypeName($companyType): string
    {
        return self::TYPE_NAME[$companyType];
    }
}
