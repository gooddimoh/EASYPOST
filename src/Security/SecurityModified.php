<?php

declare(strict_types=1);

namespace App\Security;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use Symfony\Component\Security\Core\Security;


/**
 * Class SecurityModified
 * @package App\Security
 */
class SecurityModified
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * SecurityModified constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return UserIdentity
     */
    public function getUser(): UserIdentity
    {
        /**
         * @var UserIdentity $user
         */
        $user = $this->security->getUser();

        if (!$user){
            throw new EntityNotFoundException('User not found');
        }

        return $user;
    }
}
