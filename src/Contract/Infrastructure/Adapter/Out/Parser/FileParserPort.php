<?php

namespace App\Contract\Infrastructure\Adapter\Out\Parser;

interface FileParserPort
{
    public function parse(string $filePath): array;
}