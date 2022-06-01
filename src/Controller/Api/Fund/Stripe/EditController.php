<?php

declare(strict_types=1);

namespace App\Controller\Api\Fund\Stripe;

use App\Infrastructure\Enums\Model\Transaction\MethodEnum;
use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Integrations\Stripe\DTO\PaymentIntent;
use App\Infrastructure\Integrations\Stripe\StripeClient;
use App\Infrastructure\Services\BusinessLogicService;
use App\Model\Company\UseCase\Transaction\Credit\Command as CreditCommand;
use App\Model\Company\UseCase\Transaction\Credit\Handler as CreditHandler;
use App\Model\Company\UseCase\Transaction\Unsuccessful\Command as UnsuccessfulCommand;
use App\Model\Company\UseCase\Transaction\Unsuccessful\Handler as UnsuccessfulHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/funds/stripe", name="fund.stripe")
 *
 * Class EditController
 *
 * @package App\Controller\Api\Fund\Stripe
 */
class EditController extends AbstractController
{
    /**
     * @var BusinessLogicService
     */
    private BusinessLogicService $businessLogicService;

    /**
     * @var StripeClient
     */
    private StripeClient $stripeClient;

    /**
     * EditController constructor.
     *
     * @param StripeClient         $stripeClient
     * @param BusinessLogicService $businessLogicService
     */
    public function __construct(StripeClient $stripeClient, BusinessLogicService $businessLogicService)
    {
        $this->stripeClient = $stripeClient;
        $this->businessLogicService = $businessLogicService;
    }

    /**
     * @Route("/add", name=".add", methods={"POST"})
     *
     * @param Request             $request
     * @param CreditCommand       $creditCommand
     * @param CreditHandler       $creditHandler
     * @param UnsuccessfulHandler $unsuccessfulHandler
     *
     * @return Response
     */
    public function add(
        Request             $request,
        CreditCommand       $creditCommand,
        CreditHandler       $creditHandler,
        UnsuccessfulHandler $unsuccessfulHandler
    ): Response {
        $paymentIntentId = $request->request->get('payment_intent_id');

        if (!$paymentIntentId) {
            throw new InvalidRequestParameter('Payment intent id is required.');
        }

        $paymentIntent = $this->stripeClient->retrievePaymentIntent($paymentIntentId);

        if ($paymentIntent->status !== 'succeeded') {
            $unsuccessfulCommand = new UnsuccessfulCommand();

            $unsuccessfulCommand->balance = $paymentIntent->amount;
            $unsuccessfulCommand->modifiedId = $creditCommand->modifiedId;
            $unsuccessfulCommand->method = MethodEnum::CARD;
            $unsuccessfulCommand->modifiedCompany = $creditCommand->modifiedCompany;
            $unsuccessfulCommand->description = 'Unsuccessful attempt to deposit funds by Stripe';

            $this->businessLogicService->transactional(
                fn() => $unsuccessfulHandler->handle($unsuccessfulCommand)
            );

            throw new InvalidRequestParameter('Payment error.');
        }

        $creditCommand->balance = $paymentIntent->amount;
        $creditCommand->method = MethodEnum::CARD;
        $creditCommand->description = 'Add funds by Stripe';

        $transaction = $this->businessLogicService->transactional(
            fn() => $creditHandler->handle($creditCommand)
        );

        return $this->json(
            [
                'status' => true,
                'message' => ['id' => $transaction->getId()->getValue()],
            ]
        );
    }

    /**
     * @Route("/create-payment-intent", name=".create-payment-intent", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createPaymentIntent(Request $request): Response
    {
        $amount = $request->request->get('amount');

        if (!$amount) {
            throw new InvalidRequestParameter('Amount is required.');
        }

        $paymentIntent = $this->stripeClient->createPaymentIntent(new PaymentIntent((int) $amount));

        return $this->json(
            [
                'status' => true,
                'message' => ['client_secret' => $paymentIntent->client_secret],
            ]
        );
    }
}
