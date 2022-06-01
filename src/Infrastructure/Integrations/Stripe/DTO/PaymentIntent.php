<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\Stripe\DTO;

/**
 * Class PaymentIntent
 *
 * @package App\Infrastructure\Integrations\Stripe\DTO
 */
class PaymentIntent
{
    /**
     * @var string
     */
    const DEFAULT_CURRENCY = 'usd';

    /**
     * @var string
     */
    const DEFAULT_PAYMENT_METHOD_TYPE = 'card';

    /**
     * @var int
     */
    private int $amount;

    /**
     * @var string
     */
    private string $currency;

    /**
     * @var string
     */
    private string $paymentMethodType;

    /**
     * PaymentIntent constructor.
     *
     * @param int    $amount
     * @param string $paymentMethodType
     * @param string $currency
     */
    public function __construct(
        int $amount,
        string $paymentMethodType = self::DEFAULT_PAYMENT_METHOD_TYPE,
        string $currency = self::DEFAULT_CURRENCY
    ) {
        $this->amount = $amount;
        $this->paymentMethodType = $paymentMethodType;
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getPaymentMethodType(): string
    {
        return $this->paymentMethodType;
    }
}