<?php

namespace App\Contract\Infrastructure\Adapter\Out\Http;

use App\Domain\Entity\CurrencyRate;

interface CurrencyRatePort
{
    public function getCurrencyRate(string $currency): CurrencyRate;
}