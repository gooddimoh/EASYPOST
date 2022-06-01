<?php

declare(strict_types=1);

namespace App\Controller\Api\Fund\BankTransfer\Manual;

use App\Infrastructure\Enums\Model\Stripe\Customer\StatusEnum;
use App\Infrastructure\Enums\Model\Stripe\Customer\TypeEnum;
use App\Infrastructure\Enums\Model\Transaction\MethodEnum;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Integrations\Stripe\StripeClient;
use App\Model\Company\UseCase\Transaction\Pending\Command as PendingCommand;
use App\Model\Company\UseCase\Transaction\Pending\Handler as PendingHandler;
use App\Model\Stripe\UseCase\Charge\Create\Command as ChargeCreateCommand;
use App\Model\Stripe\UseCase\Charge\Create\Handler as ChargeCreateHandler;
use App\Model\Stripe\UseCase\Customer\Create\Command as CustomerCreateCommand;
use App\Model\Stripe\UseCase\Customer\Create\Handler as CustomerCreateHandler;
use App\Model\Stripe\UseCase\Customer\Update\Command as CustomerUpdateCommand;
use App\Model\Stripe\UseCase\Customer\Update\Handler as CustomerUpdateHandler;
use App\Services\Stripe\Controller\StripeService;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\BankAccount;
use Stripe\Customer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/funds/bank-transfer/manual", name="fund.bank-transfer.manual")
 *
 * Class EditController
 *
 * @package App\Controller\Api\Fund\BankTransfer\Manual
 */
class EditController extends AbstractController
{
    /**
     * @var StripeClient
     */
    private StripeClient $stripeClient;

    /**
     * @var StripeService
     */
    private StripeService $stripeService;

    /**
     * EditController constructor.
     *
     * @param StripeClient  $stripeClient
     * @param StripeService $stripeService
     */
    public function __construct(
        StripeClient  $stripeClient,
        StripeService $stripeService
    ) {
        $this->stripeClient = $stripeClient;
        $this->stripeService = $stripeService;
    }

    /**
     * @Route("/is-customer-link", name=".is-customer-link", methods={"GET"})
     *
     * @return Response
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function isCustomerLink(): Response
    {
        $customer = $this->stripeService->getStripeCustomerByUser($this->getUser()->getId(), TypeEnum::MANUAL);

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'has_customer' => (bool) $customer,
                    'verified' => $customer && $customer['status']
                ],
            ]
        );
    }

    /**
     * @Route("/create-customer", name=".create-customer", methods={"POST"})
     *
     * @param Request               $request
     * @param CustomerCreateCommand $customerCreateCommand
     * @param CustomerCreateHandler $customerCreateHandler
     *
     * @return Response
     * @throws \Exception
     */
    public function createCustomer(
        Request               $request,
        CustomerCreateCommand $customerCreateCommand,
        CustomerCreateHandler $customerCreateHandler
    ): Response {
        $userId = $this->getUser()->getId();

        $tokenId = $request->request->get('token_id');

        if (!$tokenId) {
            throw new InvalidRequestParameter('Token id is required.');
        }

        $stripeCustomer = $this->stripeClient->createCustomer($userId, $tokenId);

        $customerCreateCommand->userId = $userId;
        $customerCreateCommand->stripeCustomerId = $stripeCustomer->id;
        $customerCreateCommand->bankAccountToken = $stripeCustomer->default_source;
        $customerCreateCommand->type = TypeEnum::MANUAL;
        $customerCreateCommand->status = StatusEnum::NOT_VERIFIED;

        $customer = $customerCreateHandler->handle($customerCreateCommand);

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'has_customer' => true,
                    'verified' => $customer->getStatus()->getValue() === StatusEnum::VERIFIED
                ],
            ]
        );
    }

    /**
     * @Route("/verify", name=".verify", methods={"POST"})
     *
     * @param Request               $request
     * @param CustomerUpdateCommand $customerUpdateCommand
     * @param CustomerUpdateHandler $customerUpdateHandler
     *
     * @return Response
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \Exception
     */
    public function verify(
        Request               $request,
        CustomerUpdateCommand $customerUpdateCommand,
        CustomerUpdateHandler $customerUpdateHandler
    ): Response {
        $userId = $this->getUser()->getId();

        $amountFirst = $request->request->get('amount_first');
        $amountSecond = $request->request->get('amount_second');

        if (
            (!$amountFirst || !is_numeric($amountFirst)) ||
            (!$amountSecond || !is_numeric($amountSecond))
        ) {
            throw new InvalidRequestParameter('Amounts are required.');
        }

        $customer = $this->stripeService->getStripeCustomerByUser($userId, TypeEnum::MANUAL);

        if (!$customer) {
            throw new EntityNotFoundException('Stripe customer not found.');
        }

        if ($customer['status'] === StatusEnum::VERIFIED) {
            throw new InvalidRequestParameter('You already verified your bank account.');
        }

        $bankAccount = $this->stripeClient->verifyCustomerBankAccountManual(
            $customer['stripe_id'],
            $customer['bank_account_token'],
            (int) $amountFirst,
            (int) $amountSecond,
        );

        if ($bankAccount->status !== BankAccount::STATUS_VERIFIED) {
            throw new InvalidRequestParameter('Invalid verification data. The bank account has not been verified.');
        }

        $customerUpdateCommand->stripeId = $bankAccount->customer instanceof Customer
            ? $bankAccount->customer->id
            : $bankAccount->customer;
        $customerUpdateCommand->status = StatusEnum::VERIFIED;

        $customerUpdateHandler->handle($customerUpdateCommand);

        return $this->json(
            [
                'status' => true,
                'message' => [
                    'has_customer' => true,
                    'verified' => true
                ],
            ]
        );
    }

    /**
     * @Route("/charge", name=".charge", methods={"POST"})
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
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
        ChargeCreateCommand    $chargeCreateCommand,
        ChargeCreateHandler    $chargeCreateHandler,
        PendingHandler         $pendingHandler
    ): Response {
        $userId = $this->getUser()->getId();

        $amount = $request->request->get('amount');

        if (!$amount || !is_numeric($amount)) {
            throw new InvalidRequestParameter('Amount is required.');
        }

        $customer = $this->stripeService->getStripeCustomerByUser($userId, TypeEnum::MANUAL);

        if (!$customer) {
            throw new EntityNotFoundException('Stripe customer not found.');
        }

        $charge = $this->stripeClient->chargeACH(
            $customer['stripe_id'],
            $customer['bank_account_token'],
            (int) $amount,
            sprintf('Postal bridge manual charge of client "%s"', $userId)
        );

        $em->beginTransaction();

        try {
            $pendingCommand = new PendingCommand();

            $pendingCommand->balance = $charge->amount;
            $pendingCommand->modifiedId = $userId;
            $pendingCommand->method = MethodEnum::BANK_TRANSFER_MANUAL_VERIFICATION;
            $pendingCommand->modifiedCompany = $this->getUser()->getCompany();
            $pendingCommand->description = 'Add funds by Bank Transfer (ACH) Manual verification';

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
