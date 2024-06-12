<?php

namespace App\Application\Service;

use App\Contract\Application\Service\TransactionServiceInterface;
use App\Contract\Domain\Service\CommissionCalculatorInterface;
use App\Contract\Infrastructure\Adapter\Out\Http\BinInfoPort;
use App\Contract\Infrastructure\Adapter\Out\Http\CurrencyRatePort;
use App\Domain\Entity\Transaction;

class TransactionService implements TransactionServiceInterface
{
    private BinInfoPort $binInfoPort;
    private CurrencyRatePort $currencyRatePort;
    private CommissionCalculatorInterface $commissionCalculator;

    public function __construct(
        BinInfoPort $binInfoPort,
        CurrencyRatePort $currencyRatePort,
        CommissionCalculatorInterface $commissionCalculator
    ) {
        $this->binInfoPort = $binInfoPort;
        $this->currencyRatePort = $currencyRatePort;
        $this->commissionCalculator = $commissionCalculator;
    }

    public function calculateCommission(Transaction $transaction): float
    {
        $binInfo = $this->binInfoPort->getBinInfo($transaction->getBin());
        $currencyRate = $this->currencyRatePort->getCurrencyRate($transaction->getCurrency());

        return $this->commissionCalculator->calculate($transaction, $binInfo, $currencyRate);
    }
}