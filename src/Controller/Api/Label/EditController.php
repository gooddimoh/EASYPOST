<?php

declare(strict_types=1);

namespace App\Controller\Api\Label;

use App\Infrastructure\Enums\Model\Transaction\MethodEnum;
use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Factory\PrimitiveTypes\Decimal;
use App\Infrastructure\Integrations\EasyPost\EasyPostClient;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\Services\BusinessLogicService;
use App\Model\Company\UseCase\Transaction\Debit\Command as DebitCommand;
use App\Model\Company\UseCase\Transaction\Debit\Handler as DebitHandler;
use App\Model\Company\UseCase\Transaction\Unsuccessful\Command as UnsuccessfulCommand;
use App\Model\Company\UseCase\Transaction\Unsuccessful\Handler as UnsuccessfulHandler;
use App\Model\Label\UseCase\Label\Create\Command as CreateCommand;
use App\Model\Label\UseCase\Label\Create\Handler as CreateHandler;
use App\Model\Label\UseCase\Label\Draft\Create\Command as CreateDraftCommand;
use App\Model\Label\UseCase\Label\Draft\Create\Handler as CreateDraftHandler;
use App\Model\Label\UseCase\Label\Draft\Update\Command as UpdateDraftCommand;
use App\Model\Label\UseCase\Label\Draft\Update\Handler as UpdateDraftHandler;
use App\Model\Label\UseCase\Label\Draft\Delete\Command as DeleteDraftCommand;
use App\Model\Label\UseCase\Label\Draft\Delete\Handler as DeleteDraftHandler;
use App\Model\Label\UseCase\Label\Update\Command as UpdateCommand;
use App\Model\Label\UseCase\Label\Update\Handler as UpdateHandler;
use App\Model\Label\UseCase\Label\ShipmentRate\Command as ShipmentRateCommand;
use App\Model\Label\UseCase\Label\ShipmentRate\Handler as ShipmentRateHandler;
use App\Model\Label\UseCase\Label\PickupRate\Command as PickupRateCommand;
use App\Model\Label\UseCase\Label\PickupRate\Handler as PickupRateHandler;
use App\Services\Carrier\Controller\CarrierService;
use App\Services\Package\Controller\PackageService;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/labels", name="label")
 *
 * Class EditController
 *
 * @package App\Controller\Api\User
 */
class EditController extends AbstractController
{
    /**
     * @Route("/create", name=".create", methods={"POST"})
     *
     * @param EasyPostClient         $easyPostClient
     * @param PackageService         $packageService
     * @param EntityManagerInterface $em
     * @param BusinessLogicService   $businessLogicService
     * @param CreateCommand          $command
     * @param CreateHandler          $handler
     * @param UnsuccessfulHandler    $unsuccessfulHandler
     * @param DebitHandler           $debitHandler
     *
     * @return Response
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \Throwable
     */
    public function create(
        EasyPostClient         $easyPostClient,
        PackageService         $packageService,
        EntityManagerInterface $em,
        BusinessLogicService   $businessLogicService,
        CreateCommand          $command,
        CreateHandler          $handler,
        UnsuccessfulHandler    $unsuccessfulHandler,
        DebitHandler           $debitHandler
    ): Response {
        $rate = $easyPostClient->retrieveShipmentRate($command->shipmentRateId);
        $companyLabelPrice = $packageService->getLabelPrice();

        $price = Decimal::create($rate->rate)->mul(100)->toInt() + $companyLabelPrice;

        $em->beginTransaction();

        try {
            $debitCommand = new DebitCommand();

            $debitCommand->balance = $price;
            $debitCommand->modifiedId = $command->modifiedId;
            $debitCommand->modifiedCompany = $command->modifiedCompany;
            $debitCommand->description = sprintf('Buy shipment "%s"', $command->shipmentId);
            $debitCommand->options = [
                'carrier' => $rate->carrier
            ];

            $debitTransaction = $debitHandler->handle($debitCommand);

            $shipment = $easyPostClient->buyShipment($command->shipmentId, $command->shipmentRateId);

            $command->track = $shipment->tracking_code ?? '';
            $command->service = $shipment->selected_rate->service ?? '';
            $command->carrier = $shipment->selected_rate->carrier ?? '';
            $command->labelUrl = $shipment->postage_label->label_pdf_url ?? $shipment->postage_label->label_url ?? '';
            $command->trackUrl = $shipment->tracker->public_url ?? '';
            $command->shipmentPrice = $debitTransaction->getBalance()->getValue();

            $label = $handler->handle($command);

            $em->commit();
        } catch (\Throwable $exception) {
            $em->rollback();
            $em->clear();

            $unsuccessfulCommand = new UnsuccessfulCommand();

            $unsuccessfulCommand->balance = $price;
            $unsuccessfulCommand->modifiedId = $command->modifiedId;
            $unsuccessfulCommand->method = MethodEnum::CARD;
            $unsuccessfulCommand->modifiedCompany = $command->modifiedCompany;
            $unsuccessfulCommand->description = 'Unsuccessful attempt to purchase label';
            $unsuccessfulCommand->options = [
                'carrier' => $rate->carrier
            ];

            $businessLogicService->transactional(fn() => $unsuccessfulHandler->handle($unsuccessfulCommand));

            throw $exception;
        }

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $label->getId()->getValue()],
            ]
        );
    }

    /**
     * @Route("/create-draft", name=".create-draft", methods={"POST"})
     *
     * @param CreateDraftCommand $command
     * @param CreateDraftHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function createDraft(
        CreateDraftCommand $command,
        CreateDraftHandler $handler
    ): Response {
        $draftLabel = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $draftLabel->getId()->getValue()],
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name=".edit", methods={"POST"})
     *
     * @param UpdateDraftCommand $command
     * @param UpdateDraftHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function editDraft(
        UpdateDraftCommand $command,
        UpdateDraftHandler $handler
    ): Response {
        $draftLabel = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $draftLabel->getId()->getValue()],
            ]
        );
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"DELETE"})
     *
     * @param string             $id
     * @param DeleteDraftCommand $command
     * @param DeleteDraftHandler $handler
     *
     * @return Response
     * @throws \Exception
     */
    public function deleteDraft(
        string             $id,
        DeleteDraftCommand $command,
        DeleteDraftHandler $handler
    ): Response {
        $handler->handle($command);

        return $this->json([
            'status' => true,
            'message' => ['id' => $id],
        ]);
    }

    /**
     * @Route("/get-shipment-rates", name=".get-shipment-rates", methods={"POST"})
     *
     * @param ShipmentRateCommand $command
     * @param ShipmentRateHandler $handler
     * @param PackageService      $packageService
     * @param CarrierService      $carrierService
     *
     * @return Response
     * @throws Exception
     * @throws ExceptionInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function getShipmentRates(
        ShipmentRateCommand $command,
        ShipmentRateHandler $handler,
        PackageService      $packageService,
        CarrierService      $carrierService
    ): Response {
        if (!$this->isGranted('ROLE_CARRIERS')) {
            throw new InvalidRequestParameter('Package not selected.');
        }

        $command->availableCarriers = (array) $carrierService->getItems(new PaginationRequest([]))->getItems();
        $command->companyLabelPrice = $packageService->getLabelPrice();

        $shipmentRatesData = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'shipment_id' => $shipmentRatesData['shipment_id'],
                    'items' => $shipmentRatesData['items'],
                    'columns' => $handler->getShipmentRatesColumns(),
                ],
            ]
        );
    }

    /**
     * @Route("/{id}/get-pickup-rates", name=".get-pickup-rates", methods={"POST"},
     *                                  requirements={"id"="[a-z0-9\-]{36}"})
     *
     * @param PickupRateCommand $command
     * @param PickupRateHandler $handler
     *
     * @return Response
     */
    public function getPickupRates(
        PickupRateCommand $command,
        PickupRateHandler $handler
    ): Response {
        $pickupRatesData = $handler->handle($command);

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'pickup_id' => $pickupRatesData['pickup_id'],
                    'items' => $pickupRatesData['items'],
                    'columns' => $handler->getPickupRatesColumns(),
                ],
            ]
        );
    }

    /**
     * @Route("/{id}/buy-pickup", name=".buy-pickup", methods={"POST"}, requirements={"id"="[a-z0-9\-]{36}"})
     *
     * @param EasyPostClient         $easyPostClient
     * @param EntityManagerInterface $em
     * @param BusinessLogicService   $businessLogicService
     * @param UnsuccessfulHandler    $unsuccessfulHandler
     * @param DebitHandler           $debitHandler
     * @param UpdateCommand          $command
     * @param UpdateHandler          $handler
     *
     * @return Response
     * @throws \Throwable
     */
    public function buyPickup(
        EasyPostClient         $easyPostClient,
        EntityManagerInterface $em,
        BusinessLogicService   $businessLogicService,
        UnsuccessfulHandler    $unsuccessfulHandler,
        DebitHandler           $debitHandler,
        UpdateCommand          $command,
        UpdateHandler          $handler
    ): Response {
        $em->beginTransaction();

        try {
            $rate = $easyPostClient->retrievePickupRate($command->pickupId, $command->pickupRateId);
            $price = Decimal::create($rate['rate'])->mul(100)->toInt();

            $debitCommand = new DebitCommand();

            $debitCommand->balance = $price;
            $debitCommand->modifiedId = $command->modifiedId;
            $debitCommand->modifiedCompany = $command->modifiedCompany;
            $debitCommand->description = sprintf('Buy pickup "%s"', $command->pickupId);
            $debitCommand->options = [
                'carrier' => $rate['carrier']
            ];

            $debitTransaction = $debitHandler->handle($debitCommand);

            $pickup = $easyPostClient->buyPickup($command->pickupId, $command->pickupRateId);

            $command->pickupRatePrice = $debitTransaction->getBalance()->getValue();

            $label = $handler->handle($command);

            $em->commit();
        } catch (\Throwable $exception) {
            $em->rollback();
            $em->clear();

            if (isset($price)) {
                $unsuccessfulCommand = new UnsuccessfulCommand();

                $unsuccessfulCommand->balance = $price;
                $unsuccessfulCommand->modifiedId = $command->modifiedId;
                $unsuccessfulCommand->method = MethodEnum::CARD;
                $unsuccessfulCommand->modifiedCompany = $command->modifiedCompany;
                $unsuccessfulCommand->description = 'Unsuccessful attempt to purchase pickup';
                $unsuccessfulCommand->options = [
                    'carrier' => $rate['carrier']
                ];

                $businessLogicService->transactional(fn() => $unsuccessfulHandler->handle($unsuccessfulCommand));
            }

            throw $exception;
        }

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $label->getId()->getValue()],
            ]
        );
    }
}
