<?php

declare(strict_types=1);


namespace App\Infrastructure\Services;

use Doctrine\ORM\EntityManagerInterface;

class BusinessLogicService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public function transactional(callable $callback)
    {
        return $this->em->transactional($callback);
    }
}
