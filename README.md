# Currency Exchange Calculator

`Currency Exchange Calculator` is a robust and scalable PHP application designed to calculate transaction commissions based on currency exchange rates and BIN information. The application follows Clean Architecture, Hexagonal Architecture principles to ensure flexibility, maintainability, and extensibility.

## Features

- Fetches BIN information from `Binlist` API.
- Retrieves current exchange rates from `Exchangerate-API`.
- Calculates commission based on transaction amount, currency, and BIN country code.

## Requirements

- PHP 8.2 or higher
- Composer

## Installation

1. Install dependencies using Composer:
   ```bash
   composer install
   ```


## Usage

To calculate transaction commissions, run the following command:

```bash
php src/Presentation/Console/app.php transactions.txt
```


### Example `transactions.txt` File

```
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
{"bin":"41417360","amount":"130.00","currency":"USD"}
{"bin":"4745030","amount":"2000.00","currency":"GBP"}
```

## Configuration

Update the `config.php` file to set API endpoints and other configurations:

```php
return [
    'bin_info_url' => 'https://lookup.binlist.net',
    'currency_rate_url' => 'https://api.exchangerate-api.com/v4/latest',
];
```


## Testing

Unit tests are provided to ensure the functionality of all components. To run the tests, execute the following command:

```bash
vendor/bin/phpunit --colors=always --testdox tests
```