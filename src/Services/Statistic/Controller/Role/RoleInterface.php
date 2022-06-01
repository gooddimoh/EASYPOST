<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Role;

use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

interface RoleInterface
{
    /**
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getData(): array;
}