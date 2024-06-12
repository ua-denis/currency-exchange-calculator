<?php

namespace App\Contract\Domain\Service;

use App\Domain\Entity\BinInfo;
use App\Domain\Entity\CurrencyRate;
use App\Domain\Entity\Transaction;

interface CommissionCalculatorInterface
{
    public function calculate(Transaction $transaction, BinInfo $binInfo, CurrencyRate $currencyRate): float;
}