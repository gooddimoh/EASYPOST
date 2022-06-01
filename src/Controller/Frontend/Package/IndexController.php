<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Package;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Model\Company\Entity\Package\Package;
use App\Services\Carrier\Controller\CarrierService;
use App\Services\Package\Controller\PackageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/packages", name="package")
 *
 * Class IndexController
 *
 * @package App\Controller\Frontend\Package
 */
class IndexController extends AbstractController
{
    /**
     * @var PackageService
     */
    private PackageService $service;

    /**
     * @var CarrierService
     */
    private CarrierService $carrierService;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     *
     * @param PackageService                $service
     * @param CarrierService                $carrierService
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        PackageService $service,
        CarrierService $carrierService,
        PaginationSerializerInterface $paginationSerializer
    ) {
        $this->service = $service;
        $this->carrierService = $carrierService;
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
        $packages = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->render(
            '/app/package/index.html.twig',
            [
                'pagination' => $this->paginationSerializer->toArray($packages),
                'items' => $packages->getItems(),
                'columns' => $this->service->getTableColumns()
            ]
        );
    }

    /**
     * @Route("/create", name=".create")
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function create(): Response
    {
        return $this->render(
            'app/package/create.html.twig',
            [
                'carriers' => $this->carrierService->getItems(new PaginationRequest([]))->getItems(),
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     *
     * @param Package $package
     *
     * @return Response
     * @throws ExceptionInterface
     */
    public function edit(Package $package): Response
    {
        return $this->render(
            'app/package/edit.html.twig',
            [
                'package' => $package,
                'carriers' => $this->carrierService->getItems(new PaginationRequest([]))->getItems(),
            ]
        );
    }

    /**
     * @Route("/{id}", name=".show")
     *
     * @param Package $package
     *
     * @return Response
     */
    public function show(Package $package): Response
    {
        return $this->render(
            'app/package/show.html.twig',
            [
                'package' => $package
            ]
        );
    }
}
