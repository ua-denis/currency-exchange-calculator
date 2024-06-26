<?php

namespace App\Infrastructure\Cache;

use App\Infrastructure\Helper\Helper;
use Memcached;

class Cache
{
    private static Memcached $memcached;

    private static function getMemcachedInstance(): Memcached
    {
        if (!isset(self::$memcached)) {
            self::$memcached = new Memcached();
            self::$memcached->addServer(
                Helper::config('cache_host'),
                Helper::config('cache_port')
            ); // Adjust the server settings as needed
        }

        return self::$memcached;
    }

    public static function get($key, $callback = null, $seconds = 60)
    {
        $memcached = self::getMemcachedInstance();
        $value = $memcached->get($key);

        if ($callback && $memcached->getResultCode() === Memcached::RES_NOTFOUND) {
            $value = $callback();
            self::put($key, $value, $seconds);
        }

        return $value;
    }

    public static function put($key, $value, $seconds): void
    {
        $memcached = self::getMemcachedInstance();
        $memcached->set($key, $value, $seconds);
    }

    public static function remember($key, $seconds, $callback)
    {
        return self::get($key, $callback, $seconds);
    }
}