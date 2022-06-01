<?php

declare(strict_types=1);

namespace App\Model\Label\Repositories\Label;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Label\Entity\Label\Fields\Id;
use App\Model\Label\Entity\Label\Label;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class LabelRepository
 * @package App\Model\Label\Repositories\Label
 */
class LabelRepository implements LabelRepositoryInterface
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
     * LabelRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Label::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     * @return Label
     */
    public function get(Id $id): Label
    {
        if (!$company = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Label not found');
        }

        return $company;
    }

    /**
     * @param Label $label
     */
    public function add(Label $label): void
    {
        $this->em->persist($label);
    }
}
