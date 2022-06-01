<?php

declare(strict_types=1);

namespace App\Model\User\Repositories\Login;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\User\Entity\Login\Fields\{Session, User};
use App\Model\User\Entity\Login\Login;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LoginRepository
 * @package App\Model\User\Repositories\Login
 */
class LoginRepository implements LoginRepositoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * LoginRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Login::class);
        $this->em = $em;
    }

    /**
     * @param Session $session
     * @return Login
     */
    public function get(Session $session): Login
    {
        if (!$login = $this->repo->findOneBy(['session.value' => $session->getValue()])) {
            throw new EntityNotFoundException('User login not found');
        }

        return $login;
    }

    /**
     * @param User $userId
     * @return bool
     */
    public function exist(User $userId): bool
    {
        $login = $this->repo->findOneBy(['userId.value' => $userId->getValue()]);

        return !!$login;
    }

    /**
     * @param Login $login
     */
    public function add(Login $login): void
    {
        $this->em->persist($login);
    }

    /**
     * @param User $id
     */
    public function delete(User $id): void
    {
        $this->em->createQueryBuilder()
            ->delete(Login::class, 't')
            ->andWhere('t.userId.value = :id')
            ->setParameter(":id", $id->getValue())
            ->getQuery()
            ->execute();
    }
}
