<?php

declare(strict_types=1);

namespace App\Controller\Frontend\AddressBook;

use App\Infrastructure\Enums\Model\AddressBook\TypeEnum;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Model\Label\Entity\AddressBook\AddressBook;
use App\Services\AddressBook\Controller\AddressBookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/address-books", name="address-book")
 */
class IndexController extends AbstractController
{
    /**
     * @var AddressBookService
     */
    private AddressBookService $service;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     * @param AddressBookService $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        AddressBookService $service,
        PaginationSerializerInterface $paginationSerializer
    )
    {
        $this->service = $service;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index")
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        $companies = $this->service->getItems(new PaginationRequest(array_merge_recursive(
            $request->query->all(),
            ['filter' => ['type' => TypeEnum::SENDER]]
        )));

        return $this->render('/app/address-book/index.html.twig', [
            'pagination' => $this->paginationSerializer->toArray($companies),
            'items' => $companies->getItems(),
            'columns' => $this->service->getTableColumns()
        ]);
    }

    /**
     * @Route("/sender", name=".createSender")
     *
     * @return Response
     */
    public function createSender(): Response
    {
        return $this->render('app/address-book/create.html.twig', [
            'type' => TypeEnum::SENDER,
        ]);
    }

    /**
     * @Route("/recipient", name=".createRecipient")
     *
     * @return Response
     */
    public function createRecipient(): Response
    {
        return $this->render('app/address-book/create.html.twig', [
            'type' => TypeEnum::RECIPIENT,
        ]);
    }

    /**
     * @Route("/{id}", name=".show")
     *
     * @param AddressBook $addressBook
     * @return Response
     */
    public function show(AddressBook $addressBook): Response
    {
        return $this->render('app/address-book/show.html.twig', [
            'addressBook' => $addressBook
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     *
     * @param AddressBook $addressBook
     * @return Response
     */
    public function edit(AddressBook $addressBook): Response
    {
        return $this->render('app/address-book/edit.html.twig', [
            'addressBook' => $addressBook
        ]);
    }
}
