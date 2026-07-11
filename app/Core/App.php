<?php

declare(strict_types=1);

namespace App\Core;

final class App
{
    private function __construct()
    {
    }

    public static function root(string $path = ''): string
    {
        return rtrim(ROOT_PATH . '/' . ltrim($path, '/'), '/');
    }

    public static function env(string $key, mixed $default = null): mixed
    {
        if (function_exists('env_value')) {
            return env_value($key, $default);
        }

        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        return ($value === false || $value === null || $value === '') ? $default : $value;
    }

    public static function isDevelopment(): bool
    {
        return defined('APP_ENV') && APP_ENV === 'development';
    }
}
