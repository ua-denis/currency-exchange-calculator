<?php

namespace Tests\Unit\Application\Service;

use App\Application\Service\TransactionService;
use App\Contract\Domain\Service\CommissionCalculatorInterface;
use App\Contract\Infrastructure\Adapter\Out\Http\BinInfoPort;
use App\Contract\Infrastructure\Adapter\Out\Http\CurrencyRatePort;
use App\Domain\Entity\BinInfo;
use App\Domain\Entity\CurrencyRate;
use App\Domain\Entity\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase
{
    public function testCalculateCommission(): void
    {
        $binInfoPortMock = $this->createMock(BinInfoPort::class);
        $currencyRatePortMock = $this->createMock(CurrencyRatePort::class);
        $commissionCalculatorMock = $this->createMock(CommissionCalculatorInterface::class);

        $binInfoPortMock->method('getBinInfo')->willReturn(new BinInfo('DE'));
        $currencyRatePortMock->method('getCurrencyRate')->willReturn(new CurrencyRate(['EUR' => 1]));
        $commissionCalculatorMock->method('calculate')->willReturn(1.0);

        $transactionService = new TransactionService(
            $binInfoPortMock, $currencyRatePortMock, $commissionCalculatorMock
        );
        $transaction = new Transaction('45717360', 100, 'EUR');

        $commission = $transactionService->calculateCommission($transaction);

        $this->assertEquals(1.0, $commission);
    }
}