<?php

declare(strict_types=1);

namespace App\Model\User\Repositories\User;

use App\Model\User\Entity\User\Fields\Email;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Fields\Id;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Interface UserRepositoryInterface
 *
 * @package App\Model\User\Repositories\User
 */
interface UserRepositoryInterface
{
    /**
     * @param Id $id
     *
     * @return User
     */
    public function get(Id $id): User;

    /**
     * @param User $user
     */
    public function add(User $user): void;

    /**
     * @param Email $email
     *
     * @return User
     */
    public function getByEmail(Email $email): User;

    /**
     * @param Email $email
     *
     * @return User
     */
    public function findByEmail(Email $email): ?User;

    /**
     * @param string $token
     *
     * @return User
     */
    public function findByResetToken(string $token): ?User;

    /**
     * @param Email $email
     *
     * @return bool
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function hasByEmail(Email $email): bool;
}