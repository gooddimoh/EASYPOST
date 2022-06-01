<?php

declare(strict_types=1);

namespace App\Model\User\Repositories\Social;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\User\Entity\Social\Fields\SocialId;
use App\Model\User\Entity\Social\Fields\Type;
use App\Model\User\Entity\Social\Social;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class SocialRepository implements SocialRepositoryInterface
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $repo;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Social::class);
        $this->em = $em;
    }

    /**
     * @param SocialId $socialId
     * @param Type     $type
     *
     * @return Social
     */
    public function get(SocialId $socialId, Type $type): Social
    {
        if (!$login = $this->repo->findOneBy(
            [
                'socialId.value' => $socialId->getValue(),
                'type.value' => $type->getValue(),
            ]
        )) {
            throw new EntityNotFoundException('Social auth not found.');
        }

        return $login;
    }

    /**
     * @param Social $social
     */
    public function add(Social $social): void
    {
        $this->em->persist($social);
    }

    /**
     * @param string $userId
     */
    public function delete(string $userId): void
    {
        $this->em->createQueryBuilder()
            ->delete(Social::class, 't')
            ->andWhere('t.user.value = :id')
            ->setParameter(":id", $userId)
            ->getQuery()
            ->execute();
    }
}
