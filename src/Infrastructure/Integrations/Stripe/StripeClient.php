<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\Stripe;

use App\Infrastructure\Exceptions\MiscommunicationException;
use App\Infrastructure\Integrations\Stripe\DTO\PaymentIntent;
use Stripe\BankAccount;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient as Stripe;
use Stripe\PaymentIntent as StripePaymentIntent;
use Stripe\Webhook;

/**
 * Class StripeClient
 *
 * @package App\Infrastructure\Integrations\Stripe
 */
class StripeClient
{
    /**
     * @var array
     */
    public const BANK_TRANSFER_CHARGE_EVENTS = [
        'SUCCESS' => 'charge.succeeded',
        'FAIL' => 'charge.failed',
    ];

    /**
     * @var Stripe
     */
    private Stripe $client;

    /**
     * @var string
     */
    private string $webhookSecret;

    /**
     * StripeClient constructor.
     *
     * @param string $apiKey
     * @param string $webhookSecret
     */
    public function __construct(string $apiKey, string $webhookSecret)
    {
        $this->client = new Stripe($apiKey);
        $this->webhookSecret = $webhookSecret;
    }

    /**
     * @param PaymentIntent $paymentIntent
     *
     * @return StripePaymentIntent
     */
    public function createPaymentIntent(PaymentIntent $paymentIntent): StripePaymentIntent
    {
        try {
            $response = $this->client->paymentIntents->create(
                [
                    'amount' => $paymentIntent->getAmount(),
                    'currency' => $paymentIntent->getCurrency(),
                    'payment_method_types' => [$paymentIntent->getPaymentMethodType()],
                ]
            );
        } catch (ApiErrorException $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create payment. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $response;
    }

    /**
     * @param string $paymentIntentId
     *
     * @return StripePaymentIntent
     */
    public function retrievePaymentIntent(string $paymentIntentId): StripePaymentIntent
    {
        try {
            $paymentIntent = $this->client->paymentIntents->retrieve($paymentIntentId);
        } catch (ApiErrorException $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve payment. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $paymentIntent;
    }

    /**
     * @param string $userId
     * @param string $stripeBankAccountToken
     *
     * @return Customer
     */
    public function createCustomer(string $userId, string $stripeBankAccountToken): Customer
    {
        try {
            $customer = $this->client->customers->create(
                [
                    'name' => $userId,
                    'source' => $stripeBankAccountToken
                ]
            );
        } catch (ApiErrorException $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create stripe customer. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $customer;
    }

    /**
     * @param string $customerId
     * @param string $source
     * @param int    $amount
     * @param string $description
     * @param string $currency
     *
     * @return Charge
     */
    public function chargeACH(
        string $customerId,
        string $source,
        int    $amount,
        string $description,
        string $currency = 'usd'
    ): Charge {
        try {
            $charge = $this->client->charges->create([
                'amount' => $amount,
                'currency' => $currency,
                'customer' => $customerId,
                'source' => $source,
                'description' => $description,
            ]);
        } catch (ApiErrorException $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create ACH charge. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $charge;
    }

    /**
     * @param string $payload
     * @param string $signatureHeader
     *
     * @return array
     */
    public function getBankTransferWebhookData(string $payload, string $signatureHeader): array
    {
        try {
            $event = Webhook::constructEvent(
                $payload,
                $signatureHeader,
                $this->webhookSecret
            );
        } catch (\UnexpectedValueException | SignatureVerificationException $e) {
            throw new MiscommunicationException(
                sprintf('Failed to parse stripe webhook data. %s', $payload),
                0,
                $e
            );
        }

        if (!in_array($event->type, self::BANK_TRANSFER_CHARGE_EVENTS, true)) {
            return [];
        }

        return [
            'success' => $event->type === self::BANK_TRANSFER_CHARGE_EVENTS['SUCCESS'],
            'charge' => $event->data->object,
        ];
    }

    /**
     * @param string $customerId
     * @param string $bankAccountId
     * @param int    $amountFirst
     * @param int    $amountSecond
     *
     * @return BankAccount
     */
    public function verifyCustomerBankAccountManual(
        string $customerId,
        string $bankAccountId,
        int    $amountFirst,
        int    $amountSecond
    ): BankAccount {
        try {
            $bankAccount = $this->client->customers->retrieveSource(
                $customerId,
                $bankAccountId
            );
        } catch (ApiErrorException $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve customer source. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        try {
            $bankAccount = $bankAccount->verify(['amounts' => [$amountFirst, $amountSecond]]);
        } catch (ApiErrorException $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to verify customer bank account. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $bankAccount;
    }
}
