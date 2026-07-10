<?php

declare(strict_types=1);

if (!function_exists('dgs_upload_file')) {
    function dgs_upload_file(array $file, string $directory, array $extensions = []): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $name = basename((string) ($file['name'] ?? ''));
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if ($extensions !== [] && !in_array($extension, $extensions, true)) {
            return null;
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $safeName = bin2hex(random_bytes(12)) . ($extension !== '' ? '.' . $extension : '');
        $target = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $safeName;

        return move_uploaded_file((string) $file['tmp_name'], $target) ? $target : null;
    }
}
