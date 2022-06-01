<?php

declare(strict_types=1);

namespace App\Controller\Api\User;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\User\Controller\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/users", name="user")
 *
 * Class IndexController
 * @package App\Controller\Api\User
 */
class IndexController extends AbstractController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     * @param UserService $userService
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        UserService $userService,
        PaginationSerializerInterface $paginationSerializer
    )
    {
        $this->userService = $userService;
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
        $companies = $this->userService->getItems(new PaginationRequest($request->query->all()));

        return $this->json([
            'status' => true,
            'message' => [
                'pagination' => $this->paginationSerializer->toArray($companies),
                'items' => $companies->getItems(),
                'columns' => $this->userService->getTableColumns()
            ]
        ]);
    }
}
