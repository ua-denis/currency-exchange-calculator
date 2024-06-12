<?php

namespace App\Domain\Service;

use App\Contract\Domain\Service\CommissionCalculatorInterface;
use App\Domain\Entity\BinInfo;
use App\Domain\Entity\CurrencyRate;
use App\Domain\Entity\Transaction;

class CommissionCalculator implements CommissionCalculatorInterface
{
    private const EU_COMMISSION_RATE = 0.01;
    private const NON_EU_COMMISSION_RATE = 0.02;
    private const EU_COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PL',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK'
    ];

    public function calculate(
        Transaction $transaction,
        BinInfo $binInfo,
        CurrencyRate $currencyRate
    ): float {
        $rate = $currencyRate->getRate($transaction->getCurrency());
        $amountInEur = $transaction->getAmount() / $rate;

        $commissionRate = in_array($binInfo->getCountryCode(), self::EU_COUNTRIES)
            ? self::EU_COMMISSION_RATE
            : self::NON_EU_COMMISSION_RATE;

        return round($amountInEur * $commissionRate, 2);
    }
}