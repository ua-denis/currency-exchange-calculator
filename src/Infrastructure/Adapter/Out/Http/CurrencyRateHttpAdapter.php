<?php

namespace App\Infrastructure\Adapter\Out\Http;

use App\Contract\Infrastructure\Adapter\Out\Http\CurrencyRatePort;
use App\Domain\Entity\CurrencyRate;
use App\Infrastructure\Cache\Cache;
use App\Infrastructure\Helper\Helper;
use App\Infrastructure\Http\HttpClient;
use GuzzleHttp\Exception\RequestException;
use RuntimeException;

class CurrencyRateHttpAdapter implements CurrencyRatePort
{
    private HttpClient $httpClient;
    private string $endpoint;
    private string $cacheKey = 'currency_rate_';

    public function __construct(HttpClient $httpClient, string $currencyRateEndpoint)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = $currencyRateEndpoint;
    }

    public function getCurrencyRate(string $currency): CurrencyRate
    {
        $cacheKey = $this->cacheKey.$currency;
        try {
            $data = Cache::remember($cacheKey, Helper::config('cache_time'), function () use ($currency) {
                $response = $this->httpClient->get("{$this->endpoint}/{$currency}");
                return json_decode($response->getBody()->getContents(), true);
            });

            if (isset($data['rates'])) {
                return new CurrencyRate($data['rates']);
            }

            throw new RuntimeException("Rates for currency not found on response");
        } catch (RequestException $e) {
            throw new RuntimeException('HTTP request failed: '.$e->getMessage());
        }
    }
}