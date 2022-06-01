<?php

declare(strict_types=1);

namespace App\Controller\Api\AddressBook;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\AddressBook\Controller\AddressBookService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/address-books", name="address-book")
 *
 * Class IndexController
 * @package App\Controller\Api\User
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
     * @Route("", name=".index", methods={"GET"})
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        $items = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->json([
            'status' => true,
            'message' => [
                'pagination' => $this->paginationSerializer->toArray($items),
                'items' => $items->getItems(),
                'columns' => $this->service->getTableColumns()
            ]
        ]);
    }

    /**
     * @Route("/sender-list", name=".sender-list")
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function senderList(Request $request): Response
    {
        $list = $this->service->getListSender(
            $request->query->get('label'),
            $request->query->get('id'),
            $request->query->get('country'),
        );

        return $this->json([
            'status' => true,
            'message' => [
                'items' => $list,
            ]
        ]);
    }

    /**
     * @Route("/recipient-list", name=".recipient-list")
     *
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function recipientList(Request $request): Response
    {
        $list = $this->service->getListRecipient(
            $request->query->get('label'),
            $request->query->get('id'),
            $request->query->get('country'),
        );

        return $this->json([
            'status' => true,
            'message' => [
                'items' => $list,
            ]
        ]);
    }
}
