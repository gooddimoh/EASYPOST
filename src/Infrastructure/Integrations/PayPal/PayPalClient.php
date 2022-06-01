<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\PayPal;

use App\Infrastructure\Exceptions\MiscommunicationException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PayPalClient
 *
 * @package App\Infrastructure\Integrations\PayPal
 */
class PayPalClient
{
    /**
     * @var PayPalHttpClient
     */
    private PayPalHttpClient $client;

    /**
     * PayPalClient constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->client = new PayPalHttpClient(new SandboxEnvironment($clientId, $clientSecret));
    }

    /**
     * @param string $orderId
     *
     * @return \stdClass
     */
    public function retrieveOrder(string $orderId): \stdClass
    {
        try {
            $response = $this->client->execute(new OrdersGetRequest($orderId));

            if ($response->statusCode !== 200 || is_string($response->result)) {
                throw new NotFoundHttpException('Order not found.');
            }

            return $response->result;
        } catch (\Throwable $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to retrieve order. %s.', $exception->getMessage()),
                0,
                $exception
            );
        }
    }
}
