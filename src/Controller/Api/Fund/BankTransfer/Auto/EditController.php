<?php

declare(strict_types=1);

namespace App\Controller\Api\Fund\BankTransfer\Auto;

use App\Infrastructure\Enums\Model\Stripe\Customer\StatusEnum;
use App\Infrastructure\Enums\Model\Stripe\Customer\TypeEnum;
use App\Infrastructure\Enums\Model\Transaction\MethodEnum;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Integrations\Plaid\PlaidClient;
use App\Infrastructure\Integrations\Stripe\StripeClient;
use App\Model\Stripe\UseCase\Customer\Create\Command as CustomerCreateCommand;
use App\Model\Stripe\UseCase\Customer\Create\Handler as CustomerCreateHandler;
use App\Model\Stripe\UseCase\Charge\Create\Command as ChargeCreateCommand;
use App\Model\Stripe\UseCase\Charge\Create\Handler as ChargeCreateHandler;
use App\Model\Company\UseCase\Transaction\Pending\Command as PendingCommand;
use App\Model\Company\UseCase\Transaction\Pending\Handler as PendingHandler;
use App\Services\Stripe\Controller\StripeService;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Customer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/funds/bank-transfer/auto", name="fund.bank-transfer.auto")
 *
 * Class EditController
 *
 * @package App\Controller\Api\Fund\BankTransfer\Auto
 */
class EditController extends AbstractController
{
    /**
     * @var PlaidClient
     */
    private PlaidClient $plaidClient;

    /**
     * @var StripeClient
     */
    private StripeClient $stripeClient;

    /**
     * EditController constructor.
     *
     * @param PlaidClient  $plaidClient
     * @param StripeClient $stripeClient
     */
    public function __construct(
        PlaidClient  $plaidClient,
        StripeClient $stripeClient
    ) {
        $this->plaidClient = $plaidClient;
        $this->stripeClient = $stripeClient;
    }

    /**
     * @Route("/create-link-token", name=".create-link-token", methods={"POST"})
     *
     * @param StripeService $stripeService
     *
     * @return Response
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function createLinkToken(StripeService $stripeService): Response
    {
        $userId = $this->getUser()->getId();
        $customer = $stripeService->getStripeCustomerByUser($userId);

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'link_token' => !$customer ? $this->plaidClient->createLinkToken($userId) : null
                ],
            ]
        );
    }

    /**
     * @Route("/new-charge", name=".new-charge", methods={"POST"})
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param CustomerCreateCommand  $customerCreateCommand
     * @param CustomerCreateHandler  $customerCreateHandler
     * @param ChargeCreateCommand    $chargeCreateCommand
     * @param ChargeCreateHandler    $chargeCreateHandler
     * @param PendingHandler         $pendingHandler
     *
     * @return Response
     * @throws \Throwable
     */
    public function newCharge(
        Request                $request,
        EntityManagerInterface $em,
        CustomerCreateCommand  $customerCreateCommand,
        CustomerCreateHandler  $customerCreateHandler,
        ChargeCreateCommand    $chargeCreateCommand,
        ChargeCreateHandler    $chargeCreateHandler,
        PendingHandler         $pendingHandler
    ): Response {
        $userId = $this->getUser()->getId();

        $publicToken = $request->request->get('public_token');
        $accountId = $request->request->get('account_id');
        $amount = $request->request->get('amount');

        if (!$publicToken || !$accountId) {
            throw new InvalidRequestParameter('Public token and account id are required.');
        }

        if (!$amount || !is_numeric($amount)) {
            throw new InvalidRequestParameter('Amount is required.');
        }

        $accessToken = $this->plaidClient->exchangePublicToken($publicToken);
        $stripeBankAccountToken = $this->plaidClient->createBankAccountToken($accessToken, $accountId);

        $stripeCustomer = $this->stripeClient->createCustomer($userId, $stripeBankAccountToken);

        $charge = $this->stripeClient->chargeACH(
            $stripeCustomer->id,
            $stripeCustomer->default_source,
            (int) $amount,
            sprintf('Postal bridge plaid charge of client #%s', $userId)
        );

        $em->beginTransaction();

        try {
            $customerCreateCommand->userId = $userId;
            $customerCreateCommand->stripeCustomerId = $charge->customer instanceof Customer
                ? $charge->customer->id
                : $charge->customer;
            $customerCreateCommand->bankAccountToken = $charge->source->id;
            $customerCreateCommand->type = TypeEnum::PLAID;
            $customerCreateCommand->status = StatusEnum::VERIFIED;

            $customer = $customerCreateHandler->handle($customerCreateCommand);

            $pendingCommand = new PendingCommand();

            $pendingCommand->balance = $charge->amount;
            $pendingCommand->modifiedId = $userId;
            $pendingCommand->method = MethodEnum::BANK_TRANSFER;
            $pendingCommand->modifiedCompany = $this->getUser()->getCompany();
            $pendingCommand->description = 'Add funds by Bank Transfer (ACH) Auto';

            $pendingTransaction = $pendingHandler->handle($pendingCommand);

            $chargeCreateCommand->userId = $userId;
            $chargeCreateCommand->companyId = $this->getUser()->getCompany();
            $chargeCreateCommand->transactionId = $pendingTransaction->getId()->getValue();
            $chargeCreateCommand->customerId = $customer->getId()->getValue();
            $chargeCreateCommand->stripeChargeId = $charge->id;
            $chargeCreateCommand->amount = $charge->amount;
            $chargeCreateCommand->data = $charge->toArray();

            $charge = $chargeCreateHandler->handle($chargeCreateCommand);

            $em->commit();
        } catch (\Throwable $exception) {
            $em->rollback();
            $em->clear();

            throw $exception;
        }

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $charge->getId()->getValue()],
            ]
        );
    }

    /**
     * @Route("/charge", name=".charge", methods={"POST"})
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param StripeService          $stripeService
     * @param ChargeCreateCommand    $chargeCreateCommand
     * @param ChargeCreateHandler    $chargeCreateHandler
     * @param PendingHandler         $pendingHandler
     *
     * @return Response
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \Throwable
     */
    public function charge(
        Request                $request,
        EntityManagerInterface $em,
        StripeService          $stripeService,
        ChargeCreateCommand    $chargeCreateCommand,
        ChargeCreateHandler    $chargeCreateHandler,
        PendingHandler         $pendingHandler
    ): Response {
        $userId = $this->getUser()->getId();

        $amount = $request->request->get('amount');

        if (!$amount || !is_numeric($amount)) {
            throw new InvalidRequestParameter('Amount is required.');
        }

        $customer = $stripeService->getStripeCustomerByUser($userId);

        if (!$customer) {
            throw new EntityNotFoundException('Stripe customer not found.');
        }

        $charge = $this->stripeClient->chargeACH(
            $customer['stripe_id'],
            $customer['bank_account_token'],
            (int) $amount,
            sprintf('Postal bridge plaid charge of client "%s"', $userId)
        );

        $em->beginTransaction();

        try {
            $pendingCommand = new PendingCommand();

            $pendingCommand->balance = $charge->amount;
            $pendingCommand->modifiedId = $userId;
            $pendingCommand->method = MethodEnum::BANK_TRANSFER;
            $pendingCommand->modifiedCompany = $this->getUser()->getCompany();
            $pendingCommand->description = 'Add funds by Bank Transfer (ACH) Auto';

            $pendingTransaction = $pendingHandler->handle($pendingCommand);

            $chargeCreateCommand->userId = $userId;
            $chargeCreateCommand->customerId = $customer['id'];
            $chargeCreateCommand->companyId = $this->getUser()->getCompany();
            $chargeCreateCommand->transactionId = $pendingTransaction->getId()->getValue();
            $chargeCreateCommand->stripeChargeId = $charge->id;
            $chargeCreateCommand->amount = $charge->amount;
            $chargeCreateCommand->data = $charge->toArray();

            $charge = $chargeCreateHandler->handle($chargeCreateCommand);

            $em->commit();
        } catch (\Throwable $exception) {
            $em->rollback();
            $em->clear();

            throw $exception;
        }

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $charge->getId()->getValue()],
            ]
        );
    }
}
