<?php

namespace App\Infrastructure\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url = '', array $options = []): ResponseInterface
    {
        return $this->client->request("GET", $url, $options);
    }
}