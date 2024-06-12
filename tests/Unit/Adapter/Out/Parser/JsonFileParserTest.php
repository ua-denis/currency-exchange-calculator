<?php

namespace Tests\Unit\Adapter\Out\Parser;

use App\Domain\Entity\Transaction;
use App\Infrastructure\Adapter\Out\Parser\JsonFileParser;
use PHPUnit\Framework\TestCase;

class JsonFileParserTest extends TestCase
{
    public function testParse(): void
    {
        $parser = new JsonFileParser();
        $transactions = $parser->parse(__DIR__.'/../../../../../transactions.txt');

        $this->assertIsArray($transactions);
        $this->assertInstanceOf(Transaction::class, $transactions[0]);
        $this->assertEquals('45717360', $transactions[0]->getBin());
        $this->assertEquals(100.0, $transactions[0]->getAmount());
        $this->assertEquals('EUR', $transactions[0]->getCurrency());
    }
}