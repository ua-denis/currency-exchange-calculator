<?php

namespace App\Infrastructure\Adapter\Out\Parser;

use App\Contract\Infrastructure\Adapter\Out\Parser\FileParserPort;
use App\Domain\Entity\Transaction;
use InvalidArgumentException;
use RuntimeException;

class JsonFileParser implements FileParserPort
{
    public function parse(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException("File not found: $filePath");
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new RuntimeException("Unable to read file: $filePath");
        }

        $lines = array_filter(explode(PHP_EOL, $content));
        $transactions = [];

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            $data = json_decode($line, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Invalid JSON in file: '.json_last_error_msg());
            }

            $transactions[] = new Transaction($data['bin'], $data['amount'], $data['currency']);
        }

        return $transactions;
    }
}