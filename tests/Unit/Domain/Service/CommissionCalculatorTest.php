<?php

namespace Tests\Unit\Domain\Service;

use App\Domain\Entity\BinInfo;
use App\Domain\Entity\CurrencyRate;
use App\Domain\Entity\Transaction;
use App\Domain\Service\CommissionCalculator;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    private CommissionCalculator $commissionCalculator;

    protected function setUp(): void
    {
        $this->commissionCalculator = new CommissionCalculator();
    }

    public function testCalculateCommissionForEuCountry(): void
    {
        $transaction = new Transaction('45717360', 100, 'EUR');
        $binInfo = new BinInfo('DE'); // Germany is an EU country
        $currencyRate = new CurrencyRate(['EUR' => 1]);

        $commission = $this->commissionCalculator->calculate($transaction, $binInfo, $currencyRate);

        $this->assertEquals(1.00, $commission);
    }

    public function testCalculateCommissionForNonEuCountry(): void
    {
        $transaction = new Transaction('45717360', 100, 'EUR');
        $binInfo = new BinInfo('US'); // US is not an EU country
        $currencyRate = new CurrencyRate(['EUR' => 1]);

        $commission = $this->commissionCalculator->calculate($transaction, $binInfo, $currencyRate);

        $this->assertEquals(2.00, $commission);
    }

    public function testCalculateCommissionWithCurrencyConversion(): void
    {
        $transaction = new Transaction('45717360', 100, 'USD');
        $binInfo = new BinInfo('FR'); // France is an EU country
        $currencyRate = new CurrencyRate(['USD' => 1.2]);

        $commission = $this->commissionCalculator->calculate($transaction, $binInfo, $currencyRate);

        $this->assertEquals(0.83, $commission);
    }

    public function testCalculateCommissionWithCurrencyConversionNonEu(): void
    {
        $transaction = new Transaction('45717360', 100, 'USD');
        $binInfo = new BinInfo('CN'); // China is not an EU country
        $currencyRate = new CurrencyRate(['USD' => 1.2]);

        $commission = $this->commissionCalculator->calculate($transaction, $binInfo, $currencyRate);

        $this->assertEquals(1.67, $commission);
    }
}