<?php

require_once __DIR__.'/../../../vendor/autoload.php';

use App\Application\Service\TransactionService;
use App\Domain\Service\CommissionCalculator;
use App\Infrastructure\Adapter\Out\Http\BinInfoHttpAdapter;
use App\Infrastructure\Adapter\Out\Http\CurrencyRateHttpAdapter;
use App\Infrastructure\Adapter\Out\Parser\JsonFileParser;
use App\Infrastructure\Http\HttpClient;

$config = require __DIR__.'/../../../config/config.php';

$httpClient = new HttpClient();
$binInfoAdapter = new BinInfoHttpAdapter($httpClient, $config['bin_info_url']);
$currencyRateAdapter = new CurrencyRateHttpAdapter($httpClient, $config['currency_rate_url']);
$commissionCalculator = new CommissionCalculator();
$fileParser = new JsonFileParser();

$transactionService = new TransactionService($binInfoAdapter, $currencyRateAdapter, $commissionCalculator);

$filePath = $argv[1] ?? $config['transactions_file'];
$transactions = $fileParser->parse($filePath);

foreach ($transactions as $transaction) {
    echo 'Commission: '.$transactionService->calculateCommission($transaction).PHP_EOL;
}