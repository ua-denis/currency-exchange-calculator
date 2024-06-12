<?php

namespace App\Domain\Entity;

class CurrencyRate
{
    private array $rates;

    public function __construct(array $rates)
    {
        $this->rates = $rates;
    }

    public function getRate(string $currency): float
    {
        return $this->rates[$currency] ?? 1.0;
    }
}