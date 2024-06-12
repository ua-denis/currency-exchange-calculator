<?php

namespace App\Contract\Application\Service;

use App\Domain\Entity\Transaction;

interface TransactionServiceInterface
{
    public function calculateCommission(Transaction $transaction): float;
}