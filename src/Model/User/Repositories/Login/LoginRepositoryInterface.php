<?php

declare(strict_types=1);

namespace App\Model\User\Repositories\Login;

use App\Model\User\Entity\Login\Fields\{Session, User};
use App\Model\User\Entity\Login\Login;

/**
 * Interface LoginRepositoryInterface
 * @package App\Model\User\Repositories\Login
 */
interface LoginRepositoryInterface
{
    /**
     * @param Session $session
     * @return Login
     */
    public function get(Session $session): Login;

    /**
     * @param Login $login
     */
    public function add(Login $login): void;

    /**
     * @param User $userId
     */
    public function delete(User $userId): void;

    /**
     * @param User $userId
     * @return bool
     */
    public function exist(User $userId): bool;
}
