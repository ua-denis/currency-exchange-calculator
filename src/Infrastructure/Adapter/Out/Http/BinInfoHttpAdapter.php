<?php

namespace App\Infrastructure\Adapter\Out\Http;

use App\Contract\Infrastructure\Adapter\Out\Http\BinInfoPort;
use App\Domain\Entity\BinInfo;
use App\Infrastructure\Http\HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use RuntimeException;

class BinInfoHttpAdapter implements BinInfoPort
{
    private HttpClient $httpClient;
    private string $endpoint;

    public function __construct(HttpClient $httpClient, string $binInfoEndpoint)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = $binInfoEndpoint;
    }

    /**
     * @throws GuzzleException
     */
    public function getBinInfo(string $bin): BinInfo
    {
        try {
            $response = $this->httpClient->get("{$this->endpoint}/{$bin}");
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['country']['alpha2'])) {
                return new BinInfo($data['country']['alpha2']);
            }

            throw new RuntimeException("'country'/'alpha2' not found on response");
        } catch (RequestException $e) {
            throw new RuntimeException('HTTP request failed: '.$e->getMessage());
        }
    }
}