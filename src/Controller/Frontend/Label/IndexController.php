<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Label;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializerInterface;
use App\Model\Label\Entity\Label\Label;
use App\Services\Label\Controller\LabelService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/labels", name="label")
 */
class IndexController extends AbstractController
{
    /**
     * @var LabelService
     */
    private LabelService $service;

    /**
     * @var PaginationSerializerInterface
     */
    private PaginationSerializerInterface $paginationSerializer;

    /**
     * IndexController constructor.
     *
     * @param LabelService                  $service
     * @param PaginationSerializerInterface $paginationSerializer
     */
    public function __construct(
        LabelService                  $service,
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
        $companies = $this->service->getItems(new PaginationRequest($request->query->all()));

        return $this->render('/app/label/index.html.twig', [
            'pagination' => $this->paginationSerializer->toArray($companies),
            'items' => $companies->getItems(),
            'columns' => $this->service->getTableColumns()
        ]);
    }

    /**
     * @Route("/create-world", name=".createWorldLabel")
     *
     * @return Response
     */
    public function createWorldLabel(): Response
    {
        return $this->render('app/label/create.html.twig', [
            'type' => 2,
        ]);
    }

    /**
     * @Route("/create-local", name=".createLocalLabel")
     *
     * @return Response
     */
    public function createLocalLabel(): Response
    {
        return $this->render('app/label/create.html.twig', [
            'type' => 1,
        ]);
    }

    /**
     * @Route("/{id}", name=".show")
     *
     * @param Label $label
     *
     * @return Response
     */
    public function show(Label $label): Response
    {
        return $this->render('app/label/show.html.twig', [
            'label' => $label
        ]);
    }

    /**
     * @Route("/{id}/clone", name=".clone")
     *
     * @param Label $label
     *
     * @return Response
     */
    public function clone(Label $label): Response
    {
        return $this->render('app/label/clone.html.twig', [
            'label' => $label
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit", methods={"GET"})
     *
     * @param Label $label
     *
     * @return Response
     */
    public function edit(Label $label): Response
    {
        if (!$label->isDraft()) {
            throw new InvalidRequestParameter('You cannot edit this label.');
        }

        return $this->render('app/label/edit.html.twig', [
            'label' => $label
        ]);
    }
}
