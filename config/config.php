<?php

return [
    'bin_info_url' => 'https://lookup.binlist.net',
    'currency_rate_url' => 'https://api.exchangerate-api.com/v4/latest',
    'transactions_file' => __DIR__.'/../transactions.txt',
    'eu_commission_rate' => 0.01,
    'non_eu_commission_rate' => 0.02,
    'eu_countries' => [
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
    ],
    'cache_time' => 3600,
    'cache_host' => 'localhost', // change to correct host name
    'cache_port' => 11211 // change to correct port name
];