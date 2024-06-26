<?php

namespace Tests\Unit\Adapter\Out\Http;

use App\Domain\Entity\CurrencyRate;
use App\Infrastructure\Adapter\Out\Http\CurrencyRateHttpAdapter;
use App\Infrastructure\Http\HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CurrencyRateHttpAdapterTest extends TestCase
{
    public function testGetCurrencyRate(): void
    {
        $clientMock = $this->createMock(HttpClient::class);
        $clientMock->method('get')->willReturn(new Response(200, [], json_encode(['rates' => ['USD' => 1.2]])));

        $adapter = new CurrencyRateHttpAdapter(
            $clientMock,
            'https://api.exchangerate-api.com/v4/latest/EUR'
        );
        $currencyRate = $adapter->getCurrencyRate('USD');

        $this->assertInstanceOf(CurrencyRate::class, $currencyRate);
        $this->assertEquals(1.2, $currencyRate->getRate('USD'));
    }
}