<?php

declare(strict_types=1);

namespace App\Middleware;

class AuthMiddleware
{
    public function handle(): bool
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        return true;
    }
}
