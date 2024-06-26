<?php

namespace Tests\Unit\Adapter\Out\Http;

use App\Domain\Entity\BinInfo;
use App\Infrastructure\Adapter\Out\Http\BinInfoHttpAdapter;
use App\Infrastructure\Http\HttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BinInfoHttpAdapterTest extends TestCase
{
    public function testGetBinInfo(): void
    {
        $clientMock = $this->createMock(HttpClient::class);
        $clientMock->method('get')->willReturn(new Response(200, [], json_encode(['country' => ['alpha2' => 'DK']])));

        $adapter = new BinInfoHttpAdapter($clientMock, 'https://lookup.binlist.net');
        $binInfo = $adapter->getBinInfo('45717360');

        $this->assertInstanceOf(BinInfo::class, $binInfo);
        $this->assertEquals('DK', $binInfo->getCountryCode());
    }
}