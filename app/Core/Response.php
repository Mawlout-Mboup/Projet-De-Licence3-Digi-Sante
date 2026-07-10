<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public static function status(int $code): void
    {
        http_response_code($code);
    }

    public static function redirect(string $path): never
    {
        $url = str_starts_with($path, 'http')
            ? $path
            : BASE_URL . '/' . ltrim($path, '/');

        header('Location: ' . $url);
        exit;
    }

    public static function json(mixed $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}
