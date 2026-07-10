<?php

declare(strict_types=1);

namespace App\Middleware;

class AdminMiddleware extends AuthMiddleware
{
    public function handle(): bool
    {
        parent::handle();

        if ((int) ($_SESSION['user']['role_id'] ?? 0) !== 1) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        return true;
    }
}
