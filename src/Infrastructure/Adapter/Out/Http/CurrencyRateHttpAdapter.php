<?php

namespace App\Infrastructure\Adapter\Out\Http;

use App\Contract\Infrastructure\Adapter\Out\Http\CurrencyRatePort;
use App\Domain\Entity\CurrencyRate;
use App\Infrastructure\Http\HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use RuntimeException;

class CurrencyRateHttpAdapter implements CurrencyRatePort
{
    private HttpClient $httpClient;
    private string $endpoint;

    public function __construct(HttpClient $httpClient, string $currencyRateEndpoint)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = $currencyRateEndpoint;
    }

    /**
     * @throws GuzzleException
     */
    public function getCurrencyRate(string $currency): CurrencyRate
    {
        try {
            $response = $this->httpClient->get("{$this->endpoint}/{$currency}");
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['rates'])) {
                return new CurrencyRate($data['rates']);
            }

            throw new RuntimeException("Rates for currency not found on response");
        } catch (RequestException $e) {
            throw new RuntimeException('HTTP request failed: '.$e->getMessage());
        }
    }
}