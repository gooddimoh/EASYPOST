<?php

declare(strict_types=1);

namespace App\Controller\Api\Carrier;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Services\Carrier\Controller\CarrierService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/carriers", name="carrier")
 *
 * Class IndexController
 *
 * @package App\Controller\Api\Carrier
 */
class IndexController extends AbstractController
{
    /**
     * @var CarrierService
     */
    private CarrierService $service;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * @param CarrierService                $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        CarrierService                $service,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->service = $service;
        $this->paginationSerializer = $paginationSerializer;
    }

    /**
     * @Route("", name=".index")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(Request $request): Response
    {
        if (!$this->isGranted('ROLE_CARRIERS')) {
            throw new InvalidRequestParameter('Package not selected.');
        }

        $carriers = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'pagination' => $this->paginationSerializer->toArray($carriers),
                    'items' => $carriers->getItems(),
                    'columns' => $this->service->getTableColumns()
                ]
            ]
        );
    }

    /**
     * @Route("/list", name=".list")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function list(Request $request): Response
    {
        $list = $this->service->getList(
            $request->query->get('label'),
            $request->query->get('id', ''),
        );

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'items' => $list,
                ]
            ]
        );
    }
}
