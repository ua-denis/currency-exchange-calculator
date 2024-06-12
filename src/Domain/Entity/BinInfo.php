<?php

namespace App\Domain\Entity;

class BinInfo
{
    private string $countryCode;

    public function __construct(string $countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}