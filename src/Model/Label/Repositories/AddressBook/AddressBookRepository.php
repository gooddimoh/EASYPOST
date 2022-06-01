<?php

declare(strict_types=1);

namespace App\Model\Label\Repositories\AddressBook;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Model\Label\Entity\AddressBook\Fields\Id;
use App\Model\Label\Entity\AddressBook\AddressBook;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class LabelRepository
 * @package App\Model\Label\Repositories\AddressBook
 */
class AddressBookRepository implements AddressBookRepositoryInterface
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
        $this->repo = $em->getRepository(AddressBook::class);
        $this->em = $em;
    }

    /**
     * @param Id $id
     * @return AddressBook
     */
    public function get(Id $id): AddressBook
    {
        if (!$company = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Label not found');
        }

        return $company;
    }

    /**
     * @param AddressBook $Label
     */
    public function add(AddressBook $Label): void
    {
        $this->em->persist($Label);
    }
}
