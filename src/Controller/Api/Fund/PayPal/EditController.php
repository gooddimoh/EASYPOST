<?php

declare(strict_types=1);

namespace App\Controller\Api\Fund\PayPal;

use App\Infrastructure\Enums\Model\Transaction\MethodEnum;
use App\Infrastructure\Exceptions\InvalidRequestParameter;
use App\Infrastructure\Factory\PrimitiveTypes\Decimal;
use App\Infrastructure\Integrations\PayPal\PayPalClient;
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
 * @Route("/funds/paypal", name="fund.paypal")
 *
 * Class EditController
 *
 * @package App\Controller\Api\Fund\PayPal
 */
class EditController extends AbstractController
{
    /**
     * @var BusinessLogicService
     */
    private BusinessLogicService $businessLogicService;

    /**
     * @var PayPalClient
     */
    private PayPalClient $payPalClient;

    /**
     * EditController constructor.
     *
     * @param PayPalClient         $payPalClient
     * @param BusinessLogicService $businessLogicService
     */
    public function __construct(PayPalClient $payPalClient, BusinessLogicService $businessLogicService)
    {
        $this->payPalClient = $payPalClient;
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
        $orderId = $request->request->get('order_id');

        if (!$orderId) {
            throw new InvalidRequestParameter('Order id is required.');
        }

        $order = $this->payPalClient->retrieveOrder($orderId);

        $amount = Decimal::create(array_shift($order->purchase_units)->amount->value)
            ->mul(100)
            ->toInt(); // переводим в центы

        if ($order->intent !== 'CAPTURE' || $order->status !== 'APPROVED') {
            $unsuccessfulCommand = new UnsuccessfulCommand();

            $unsuccessfulCommand->balance = $amount;
            $unsuccessfulCommand->modifiedId = $creditCommand->modifiedId;
            $unsuccessfulCommand->method = MethodEnum::PayPal;
            $unsuccessfulCommand->modifiedCompany = $creditCommand->modifiedCompany;
            $unsuccessfulCommand->description = 'Unsuccessful attempt to deposit funds by PayPal';

            $this->businessLogicService->transactional(
                fn() => $unsuccessfulHandler->handle($unsuccessfulCommand)
            );

            throw new InvalidRequestParameter('Payment error.');
        }

        $creditCommand->balance = $amount;
        $creditCommand->method = MethodEnum::PayPal;
        $creditCommand->description = 'Add funds by PayPal';

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
}
