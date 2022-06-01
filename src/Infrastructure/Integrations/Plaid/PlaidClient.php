<?php

declare(strict_types=1);

namespace App\Infrastructure\Integrations\Plaid;

use App\Infrastructure\Exceptions\MiscommunicationException;
use TomorrowIdeas\Plaid\Entities\User;
use TomorrowIdeas\Plaid\Plaid;

/**
 * Class PlaidClient
 *
 * @package App\Infrastructure\Integrations\Plaid
 */
class PlaidClient
{
    /**
     * @var Plaid
     */
    private Plaid $client;

    /**
     * @param string $clientId
     * @param string $secret
     * @param string $environment
     */
    public function __construct(string $clientId, string $secret, string $environment)
    {
        $this->client = new Plaid($clientId, $secret, $environment);
    }

    /**
     * @param string         $clientUserId
     * @param string         $clientName
     * @param string         $language
     * @param array|string[] $countryCodes
     * @param array|string[] $products
     *
     * @return string
     */
    public function createLinkToken(
        string $clientUserId,
        string $clientName = 'PostalBridge',
        string $language = 'en',
        array  $countryCodes = ['US', 'CA'],
        array  $products = ['auth']
    ): string {
        try {
            $linkToken = $this->client->tokens->create(
                $clientName,
                $language,
                $countryCodes,
                new User($clientUserId),
                $products
            );
        } catch (\Throwable $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create plaid link token. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $linkToken->link_token;
    }

    /**
     * @param string $clientPublicToken
     *
     * @return string
     */
    public function exchangePublicToken(string $clientPublicToken): string
    {
        try {
            $accessToken = $this->client->items->exchangeToken($clientPublicToken);
        } catch (\Throwable $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to exchange plaid public token. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $accessToken->access_token;
    }

    /**
     * @param string $accessToken
     * @param string $accountId
     *
     * @return string
     */
    public function createBankAccountToken(string $accessToken, string $accountId): string
    {
        try {
            $stripeBankAccountToken = $this->client->processors->createStripeToken($accessToken, $accountId);
        } catch (\Throwable $exception) {
            throw new MiscommunicationException(
                sprintf('Failed to create stripe bank account token. %s', $exception->getMessage()),
                0,
                $exception
            );
        }

        return $stripeBankAccountToken->stripe_bank_account_token;
    }
}
