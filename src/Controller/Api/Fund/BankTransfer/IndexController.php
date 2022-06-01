<?php

declare(strict_types=1);

namespace App\Controller\Api\Fund\BankTransfer;

use App\Infrastructure\Integrations\Stripe\StripeClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Stripe\Charge;
use App\Infrastructure\Enums\Model\Transaction\StatusEnum as TransactionStatusEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\Stripe\UseCase\Charge\Update\Command as ChargeUpdateCommand;
use App\Model\Stripe\UseCase\Charge\Update\Handler as ChargeUpdateHandler;
use App\Model\Company\UseCase\Transaction\Update\Command as UpdateCommand;
use App\Model\Company\UseCase\Transaction\Update\Handler as UpdateHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/funds/bank-transfer", name="fund.bank-transfer")
 */
class IndexController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var StripeClient
     */
    private StripeClient $stripeClient;

    /**
     * @param LoggerInterface $logger
     * @param StripeClient    $stripeClient
     */
    public function __construct(
        LoggerInterface $logger,
        StripeClient    $stripeClient
    ) {
        $this->logger = $logger;
        $this->stripeClient = $stripeClient;
    }

    /**
     * @Route("/callback", name=".callback", methods={"POST"} )
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param ChargeUpdateCommand    $chargeUpdateCommand
     * @param ChargeUpdateHandler    $chargeUpdateHandler
     * @param UpdateCommand          $updateCommand
     * @param UpdateHandler          $updateHandler
     *
     * @return Response
     */
    public function callback(
        Request                $request,
        EntityManagerInterface $em,
        ChargeUpdateCommand    $chargeUpdateCommand,
        ChargeUpdateHandler    $chargeUpdateHandler,
        UpdateCommand          $updateCommand,
        UpdateHandler          $updateHandler
    ): Response {
        $payload = @file_get_contents('php://input');

        $data = $this->stripeClient->getBankTransferWebhookData(
            $payload,
            $request->headers->get('STRIPE_SIGNATURE')
        );

        if (!$data) {
            $this->logger->info('Unsupported bank transfer webhook charge event.');
        }

        /**
         * @var Charge $charge
         */
        $charge = $data['charge'];
        $status = $data['success'] ? TransactionStatusEnum::SUCCESS : TransactionStatusEnum::FAIL;

        $em->beginTransaction();

        try {
            $chargeUpdateCommand->stripeId = $charge->id;
            $chargeUpdateCommand->status = $status;
            $chargeUpdateCommand->data = $charge->toArray();

            $chargeModel = $chargeUpdateHandler->handle($chargeUpdateCommand);

            $updateCommand->id = $chargeModel->getTransaction()->getValue();
            $updateCommand->status = $status;

            $updateHandler->handle($updateCommand);

            $em->commit();
        } catch (\Throwable $exception) {
            $em->rollback();
            $em->clear();

            $this->logger->critical(
                sprintf(
                    'Error processing bank transfer charge callback. Exception - %s. Payload - %s',
                    $exception->getMessage(),
                    $payload
                ),
                ['exception' => $exception]
            );
        }

        return new Response();
    }
}
