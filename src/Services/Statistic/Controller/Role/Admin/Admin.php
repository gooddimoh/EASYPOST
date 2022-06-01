<?php

declare(strict_types=1);

namespace App\Services\Statistic\Controller\Role\Admin;

use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Services\Statistic\Controller\Role\RoleInterface;
use App\Services\Statistic\Controller\Type\Carrier;
use App\Services\Statistic\Controller\Type\Credit;
use App\Services\Statistic\Controller\Type\Income;
use App\Services\Statistic\Controller\Type\Label;
use App\Services\Statistic\Controller\Type\Registration;
use App\Services\Statistic\Controller\Type\StatisticLabel;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class Admin implements RoleInterface
{
    /**
     * @var Credit
     */
    private Credit $credit;

    /**
     * @var Carrier
     */
    private Carrier $carrier;

    /**
     * @var Registration
     */
    private Registration $registration;

    /**
     * @var Income
     */
    private Income $income;

    /**
     * @var Label
     */
    private Label $label;

    /**
     * @var StatisticLabel
     */
    private StatisticLabel $statisticLabel;

    /**
     * @param Credit         $credit
     * @param Carrier        $carrier
     * @param Registration   $registration
     * @param Income         $income
     * @param Label          $label
     * @param StatisticLabel $statisticLabel
     */
    public function __construct(
        Credit         $credit,
        Carrier        $carrier,
        Registration   $registration,
        Income         $income,
        Label          $label,
        StatisticLabel $statisticLabel
    ) {
        $this->credit = $credit;
        $this->carrier = $carrier;
        $this->registration = $registration;
        $this->income = $income;
        $this->label = $label;
        $this->statisticLabel = $statisticLabel;
    }

    /**
     * @return array
     * @throws ExceptionInterface
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function getData(): array
    {
        $defaultFilter = new PaginationRequest([
            'filter' => [
                'date_from' => date('Y-m-01'),
                'date_to' => date('Y-m-d')
            ]
        ]);

        return [
            'income' => $this->income($defaultFilter),
            'credit' => $this->credit($defaultFilter),
            'registration' => $this->registration($defaultFilter),
            'label' => $this->label($defaultFilter),
            'carrier' => $this->carrier($defaultFilter),
            'statistic_label' => $this->statisticLabel($defaultFilter),
        ];
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function income(PaginationRequestInterface $paginationRequest): array
    {
        return $this->income->getData($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function credit(PaginationRequestInterface $paginationRequest): array
    {
        return $this->credit->getData($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function registration(PaginationRequestInterface $paginationRequest): array
    {
        return $this->registration->getData($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function label(PaginationRequestInterface $paginationRequest): array
    {
        return $this->label->getData($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function carrier(PaginationRequestInterface $paginationRequest): array
    {
        return $this->carrier->getData($paginationRequest);
    }

    /**
     * @param PaginationRequestInterface $paginationRequest
     *
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function statisticLabel(PaginationRequestInterface $paginationRequest): array
    {
        return $this->statisticLabel->getData($paginationRequest);
    }
}