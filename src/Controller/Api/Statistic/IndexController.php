<?php

declare(strict_types=1);

namespace App\Controller\Api\Statistic;

use App\Infrastructure\Exceptions\InvalidRequestData;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Services\Statistic\Controller\StatisticService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/statistics", name="statistic")
 */
class IndexController extends AbstractController
{
    /**
     * @var StatisticService
     */
    private StatisticService $statisticService;

    /**
     * @param StatisticService $statisticService
     */
    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    /**
     * @Route("/income", name=".income")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function income(Request $request): Response
    {
        return $this->json(
            [
                'status' => true,
                'message' => $this->statisticService->income(new PaginationRequest($request->query->all()))
            ]
        );
    }

    /**
     * @Route("/credit", name=".credit")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function credit(Request $request): Response
    {
        return $this->json(
            [
                'status' => true,
                'message' => $this->statisticService->credit(new PaginationRequest($request->query->all()))
            ]
        );
    }

    /**
     * @Route("/registration", name=".registration")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function registration(Request $request): Response
    {
        return $this->json(
            [
                'status' => true,
                'message' => $this->statisticService->registration(new PaginationRequest($request->query->all()))
            ]
        );
    }

    /**
     * @Route("/label", name=".label")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function label(Request $request): Response
    {
        return $this->json(
            [
                'status' => true,
                'message' => $this->statisticService->label(new PaginationRequest($request->query->all()))
            ]
        );
    }

    /**
     * @Route("/carrier", name=".carrier")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function carrier(Request $request): Response
    {
        return $this->json(
            [
                'status' => true,
                'message' => $this->statisticService->carrier(new PaginationRequest($request->query->all()))
            ]
        );
    }

    /**
     * @Route("/statistic-label", name=".statistic-label")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function statisticLabel(Request $request): Response
    {
        return $this->json(
            [
                'status' => true,
                'message' => $this->statisticService->statisticLabel(
                    new PaginationRequest(
                        array_replace_recursive(
                            [
                                'filter' => [
                                    'date_from' => date('Y-m-01'),
                                    'date_to' => date('Y-m-d')
                                ]
                            ],
                            $request->query->all()
                        )
                    )
                )
            ]
        );
    }
}
