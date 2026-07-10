<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(
        string $view,
        array $data = []
    ): void {

        extract($data);

        $viewFile = VIEW_PATH . '/' . $view . '.php';

        if (!file_exists($viewFile)) {

            throw new \Exception(
                "Vue introuvable : {$view}"
            );

        }

        ob_start();

        require $viewFile;

        $content = ob_get_clean();

        require VIEW_PATH . '/layouts/master.php';

    }

    protected function redirect(
        string $url
    ): void {

        header(
            'Location: ' .
            BASE_URL .
            '/' .
            ltrim($url, '/')
        );

        exit;

    }

    protected function json(
        mixed $data,
        int $status = 200
    ): void {

        http_response_code($status);

        header(
            'Content-Type: application/json; charset=UTF-8'
        );

        echo json_encode(
            $data,
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_UNICODE
        );

        exit;

    }

    protected function input(
        string $key,
        mixed $default = null
    ): mixed {

        return $_POST[$key]
            ?? $_GET[$key]
            ?? $default;

    }

    protected function isPost(): bool
    {

        return
            $_SERVER['REQUEST_METHOD']
            ===
            'POST';

    }

    protected function isGet(): bool
    {

        return
            $_SERVER['REQUEST_METHOD']
            ===
            'GET';

    }

    protected function back(): void
    {

        header(

            'Location: ' .

            ($_SERVER['HTTP_REFERER']

            ?? BASE_URL)

        );

        exit;

    }

    protected function session(
        string $key,
        mixed $value = null
    ): mixed {

        if ($value === null) {

            return $_SESSION[$key] ?? null;

        }

        $_SESSION[$key] = $value;

        return $value;

    }

    protected function destroySession(): void
    {

        $_SESSION = [];

        session_destroy();

    }

    protected function auth(): bool
    {

        return isset($_SESSION['user']);

    }

    protected function user(): ?array
    {

        return $_SESSION['user'] ?? null;

    }

    protected function requireAuth(): array
    {
        if (!$this->auth()) {
            $this->redirect('login');
        }

        return $this->user() ?? [];
    }

    protected function roleId(): int
    {
        return (int) ($this->user()['role_id'] ?? 0);
    }

    protected function dashboardPathForRole(?int $roleId = null): string
    {
        return match ($roleId ?? $this->roleId()) {
            1 => 'dashboard/admin',
            3 => 'dashboard/patient',
            default => 'dashboard/medecin'
        };
    }

    protected function requireRole(int|array $roles): array
    {
        $user = $this->requireAuth();
        $allowed = is_array($roles) ? $roles : [$roles];

        if (!in_array((int) ($user['role_id'] ?? 0), $allowed, true)) {
            $this->redirect($this->dashboardPathForRole((int) ($user['role_id'] ?? 0)));
        }

        return $user;
    }

    protected function abort(
        int $code = 404,
        string $message = 'Page introuvable'
    ): never {

        http_response_code($code);

        exit($message);

    }
}