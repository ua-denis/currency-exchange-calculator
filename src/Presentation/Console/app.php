<?php

require_once __DIR__.'/../../../vendor/autoload.php';

use App\Application\Service\TransactionService;
use App\Domain\Service\CommissionCalculator;
use App\Infrastructure\Adapter\Out\Http\BinInfoHttpAdapter;
use App\Infrastructure\Adapter\Out\Http\CurrencyRateHttpAdapter;
use App\Infrastructure\Adapter\Out\Parser\JsonFileParser;
use App\Infrastructure\Helper\Helper;
use App\Infrastructure\Http\HttpClient;

$httpClient = new HttpClient();
$binInfoAdapter = new BinInfoHttpAdapter($httpClient, Helper::config('bin_info_url'));
$currencyRateAdapter = new CurrencyRateHttpAdapter($httpClient, Helper::config('currency_rate_url'));
$commissionCalculator = new CommissionCalculator();
$fileParser = new JsonFileParser();

$transactionService = new TransactionService($binInfoAdapter, $currencyRateAdapter, $commissionCalculator);

$filePath = $argv[1] ?? Helper::config('transactions_file');
$transactions = $fileParser->parse($filePath);

foreach ($transactions as $transaction) {
    echo 'Commission: '.$transactionService->calculateCommission($transaction).PHP_EOL;
}