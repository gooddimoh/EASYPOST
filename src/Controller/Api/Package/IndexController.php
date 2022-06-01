<?php

declare(strict_types=1);

namespace App\Controller\Api\Package;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\Package\Controller\PackageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/packages", name="package")
 *
 * Class IndexController
 *
 * @package App\Controller\Api\Package
 */
class IndexController extends AbstractController
{
    /**
     * @var PackageService
     */
    private PackageService $service;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     *
     * @param PackageService                $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        PackageService $service,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->service = $service;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        $packages = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'pagination' => $this->paginationSerializer->toArray($packages),
                    'items' => $packages->getItems(),
                    'columns' => $this->service->getTableColumns()
                ]
            ]
        );
    }

    /**
     * @Route("/list", name=".list")
     *
     * @param Request $request
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function list(Request $request): Response
    {
        $list = $this->service->getList(
            $request->query->get('label'),
            $request->query->get('id', ''),
        );

        return $this->json([
            'status' => true,
            'message' => [
                'items' => $list,
            ]
        ]);
    }
}
