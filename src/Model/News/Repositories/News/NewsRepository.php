<?php

declare(strict_types=1);

namespace App\Model\News\Repositories\News;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\News\Entity\News\News;
use App\Model\News\Entity\News\Fields\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class NewsRepository implements NewsRepositoryInterface
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
        $this->repo = $em->getRepository(News::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     *
     * @return News
     */
    public function get(Id $id): News
    {
        if (!$news = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('News not found.');
        }

        return $news;
    }

    /**
     * @param News $news
     */
    public function add(News $news): void
    {
        $this->em->persist($news);
    }
}
