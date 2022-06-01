<?php

declare(strict_types=1);

namespace App\Model\User\Repositories\User;

use App\Infrastructure\Enums\Model\User\StatusEnum;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\User\Entity\User\Fields\{Email};
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Fields\Id;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserRepository
 *
 * @package App\Model\User\Repositories\User
 */
class UserRepository implements UserRepositoryInterface
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
     * UserRepository constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(User::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     *
     * @return User
     */
    public function get(Id $id): User
    {
        if (!$user = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('User not found');
        }

        return $user;
    }

    /**
     * @param User $user
     */
    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    /**
     * @param Email $email
     * @return User|null
     */
    public function findByEmail(Email $email): ?User
    {
        /** @var User $user */
        $user = $this->repo->createQueryBuilder('t')
            ->andWhere('LOWER(t.email.value) = LOWER(:email) and t.status.value != :status')
            ->setParameter(':email', $email->getValue())
            ->setParameter(':status', StatusEnum::BLOCK)
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();

        if (!$user) {
            return null;
        }

        return $user[0];
    }

    /**
     * @param Email $email
     * @return User
     */
    public function getByEmail(Email $email): User
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            throw new EntityNotFoundException('User is not found.');
        }

        return $user;
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function hasByEmail(Email $email): bool
    {
        return !!$this->findByEmail($email);
    }

    /**
     * @param string $token
     *
     * @return User
     */
    public function findByResetToken(string $token): ?User
    {
        return $this->repo->findOneBy(['resetToken.token' => $token]);
    }
}
