<?php

namespace App\Domain\Service;

use App\Contract\Domain\Service\CommissionCalculatorInterface;
use App\Domain\Entity\BinInfo;
use App\Domain\Entity\CurrencyRate;
use App\Domain\Entity\Transaction;
use App\Infrastructure\Helper\Helper;

class CommissionCalculator implements CommissionCalculatorInterface
{
    public function calculate(
        Transaction $transaction,
        BinInfo $binInfo,
        CurrencyRate $currencyRate
    ): float {
        $rate = $currencyRate->getRate($transaction->getCurrency());
        $amountInEur = $transaction->getAmount() / $rate;

        $commissionRate = in_array($binInfo->getCountryCode(), Helper::config('eu_countries'))
            ? Helper::config('eu_commission_rate')
            : Helper::config('non_eu_commission_rate');

        return round($amountInEur * $commissionRate, 2);
    }
}