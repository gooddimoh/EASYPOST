<?php

declare(strict_types=1);

namespace App\Controller\Frontend\Statistic;

use App\Infrastructure\Exceptions\InvalidRequestData;
use App\Services\Statistic\Controller\StatisticService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/statistics", name="statistic")
 */
class StatisticController extends AbstractController
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
     * @Route("", name=".index", methods={"GET"})
     *
     * @return Response
     * @throws InvalidRequestData
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws ExceptionInterface
     */
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($this->generateUrl('dashboard.index'));
        }

        return $this->render('/app/statistic/index.html.twig', [
            'statistic' => $this->statisticService->wholeDashboard(),
        ]);
    }
}
