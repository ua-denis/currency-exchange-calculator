<?php

namespace App\Contract\Infrastructure\Adapter\Out\Http;

use App\Domain\Entity\BinInfo;

interface BinInfoPort
{
    public function getBinInfo(string $bin): BinInfo;
}