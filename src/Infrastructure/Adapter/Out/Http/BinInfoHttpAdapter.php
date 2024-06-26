<?php

namespace App\Infrastructure\Adapter\Out\Http;

use App\Contract\Infrastructure\Adapter\Out\Http\BinInfoPort;
use App\Domain\Entity\BinInfo;
use App\Infrastructure\Cache\Cache;
use App\Infrastructure\Helper\Helper;
use App\Infrastructure\Http\HttpClient;
use GuzzleHttp\Exception\RequestException;
use RuntimeException;

class BinInfoHttpAdapter implements BinInfoPort
{
    private HttpClient $httpClient;
    private string $endpoint;
    private string $cacheKey = 'bin_info_';

    public function __construct(HttpClient $httpClient, string $binInfoEndpoint)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = $binInfoEndpoint;
    }

    public function getBinInfo(string $bin): BinInfo
    {
        $cacheKey = $this->cacheKey.$bin;
        try {
            $data = Cache::remember($cacheKey, Helper::config('cache_time'), function () use ($bin) {
                $response = $this->httpClient->get("{$this->endpoint}/{$bin}");
                return json_decode($response->getBody()->getContents(), true);
            });

            if (isset($data['country']['alpha2'])) {
                return new BinInfo($data['country']['alpha2']);
            }

            throw new RuntimeException("'country'/'alpha2' not found on response");
        } catch (RequestException $e) {
            throw new RuntimeException('HTTP request failed: '.$e->getMessage());
        }
    }
}