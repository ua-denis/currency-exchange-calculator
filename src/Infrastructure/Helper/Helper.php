<?php

namespace App\Infrastructure\Helper;

class Helper
{
    private static $config = null;

    public static function config($key)
    {
        if (self::$config === null) {
            self::$config = require __DIR__.'/../../../config/config.php';
        }

        return self::$config[$key] ?? null;
    }
}