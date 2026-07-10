<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    public function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    }

    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function ip(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
}
