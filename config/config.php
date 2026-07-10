<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| CHEMINS DE BASE ET ENVIRONNEMENT
|--------------------------------------------------------------------------
*/

defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));

if (!function_exists('dgs_load_env')) {
    function dgs_load_env(string $path): void
    {
        if (!is_file($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if ($key === '' || preg_match('/^[A-Z0-9_]+$/i', $key) !== 1) {
                continue;
            }

            if ($value !== '' && (
                ($value[0] === '"' && substr($value, -1) === '"') ||
                ($value[0] === "'" && substr($value, -1) === "'")
            )) {
                $value = substr($value, 1, -1);
            }

            $_ENV[$key] = $_ENV[$key] ?? $value;
            $_SERVER[$key] = $_SERVER[$key] ?? $value;

            if (getenv($key) === false) {
                putenv($key . '=' . $value);
            }
        }
    }
}

if (!function_exists('env_value')) {
    function env_value(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null || $value === '') {
            return $default;
        }

        return $value;
    }
}

if (!function_exists('dgs_detect_base_url')) {
    function dgs_detect_base_url(): string
    {
        $configuredUrl = trim((string) env_value('APP_URL', 'auto'));

        if ($configuredUrl !== '' && strtolower($configuredUrl) !== 'auto') {
            return rtrim($configuredUrl, '/');
        }

        if (PHP_SAPI !== 'cli' && !empty($_SERVER['HTTP_HOST'])) {
            $isHttps = (
                (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                ((string) ($_SERVER['SERVER_PORT'] ?? '') === '443')
            );

            $scheme = $isHttps ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
            $basePath = rtrim(dirname($scriptName), '/\\');

            if ($basePath === '.' || $basePath === '/') {
                $basePath = '';
            }

            return rtrim($scheme . '://' . $host . $basePath, '/');
        }

        return 'http://localhost/' . rawurlencode(basename(ROOT_PATH)) . '/public';
    }
}

dgs_load_env(ROOT_PATH . '/.env');

/*
|--------------------------------------------------------------------------
| APPLICATION
|--------------------------------------------------------------------------
*/

defined('APP_NAME') || define('APP_NAME', (string) env_value('APP_NAME', 'DIGI-SANTE'));
defined('APP_VERSION') || define('APP_VERSION', (string) env_value('APP_VERSION', '1.0.0'));
defined('APP_ENV') || define('APP_ENV', (string) env_value('APP_ENV', 'development'));

/*
|--------------------------------------------------------------------------
| URL
|--------------------------------------------------------------------------
*/

defined('BASE_URL') || define('BASE_URL', dgs_detect_base_url());
defined('BASE_PATH') || define(
    'BASE_PATH',
    rtrim((string) (parse_url(BASE_URL, PHP_URL_PATH) ?? ''), '/')
);

/*
|--------------------------------------------------------------------------
| TIMEZONE
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Africa/Dakar');

/*
|--------------------------------------------------------------------------
| ENCODAGE
|--------------------------------------------------------------------------
*/

mb_internal_encoding('UTF-8');
ini_set('default_charset', 'UTF-8');

/*
|--------------------------------------------------------------------------
| ERREURS
|--------------------------------------------------------------------------
*/

if (APP_ENV === 'development') {

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

} else {

    ini_set('display_errors', '0');
    error_reporting(0);

}

/*
|--------------------------------------------------------------------------
| SESSION
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| CHEMINS
|--------------------------------------------------------------------------
*/

defined('APP_PATH') || define('APP_PATH', ROOT_PATH . '/app');

defined('CONFIG_PATH') || define('CONFIG_PATH', ROOT_PATH . '/config');

defined('DATABASE_PATH') || define('DATABASE_PATH', ROOT_PATH . '/database');

defined('PUBLIC_PATH') || define('PUBLIC_PATH', ROOT_PATH . '/public');

defined('ROUTES_PATH') || define('ROUTES_PATH', ROOT_PATH . '/routes');

defined('STORAGE_PATH') || define('STORAGE_PATH', ROOT_PATH . '/storage');

defined('CONTROLLER_PATH') || define('CONTROLLER_PATH', APP_PATH . '/Controllers');

defined('MODEL_PATH') || define('MODEL_PATH', APP_PATH . '/Models');

defined('VIEW_PATH') || define('VIEW_PATH', APP_PATH . '/Views');

defined('CORE_PATH') || define('CORE_PATH', APP_PATH . '/Core');

defined('HELPER_PATH') || define('HELPER_PATH', APP_PATH . '/Helpers');

defined('MIDDLEWARE_PATH') || define('MIDDLEWARE_PATH', APP_PATH . '/Middleware');

/*
|--------------------------------------------------------------------------
| STOCKAGE
|--------------------------------------------------------------------------
*/

defined('UPLOAD_PATH') || define('UPLOAD_PATH', STORAGE_PATH . '/uploads');

defined('PDF_PATH') || define('PDF_PATH', STORAGE_PATH . '/pdf');

defined('LOG_PATH') || define('LOG_PATH', STORAGE_PATH . '/logs');

/*
|--------------------------------------------------------------------------
| ASSETS
|--------------------------------------------------------------------------
*/

defined('ASSET_PATH') || define('ASSET_PATH', BASE_URL . '/assets');

defined('CSS_PATH') || define('CSS_PATH', ASSET_PATH . '/css');

defined('JS_PATH') || define('JS_PATH', ASSET_PATH . '/js');

defined('IMAGE_PATH') || define('IMAGE_PATH', ASSET_PATH . '/images');

/*
|--------------------------------------------------------------------------
| SECURITE
|--------------------------------------------------------------------------
*/

defined('PASSWORD_ALGO') || define('PASSWORD_ALGO', PASSWORD_BCRYPT);

defined('PASSWORD_COST') || define('PASSWORD_COST', 12);

/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/

defined('ITEMS_PER_PAGE') || define('ITEMS_PER_PAGE', 10);

/*
|--------------------------------------------------------------------------
| ALERTES
|--------------------------------------------------------------------------
*/

defined('ALERTE_FAIBLE') || define('ALERTE_FAIBLE', 'Faible');

defined('ALERTE_MOYEN') || define('ALERTE_MOYEN', 'Moyen');

defined('ALERTE_ELEVE') || define('ALERTE_ELEVE', 'Eleve');

defined('ALERTE_CRITIQUE') || define('ALERTE_CRITIQUE', 'Critique');

/*
|--------------------------------------------------------------------------
| CONSTANTES VITALES
|--------------------------------------------------------------------------
*/

defined('TEMP_MIN') || define('TEMP_MIN', 36.0);

defined('TEMP_MAX') || define('TEMP_MAX', 38.0);

defined('POULS_MIN') || define('POULS_MIN', 60);

defined('POULS_MAX') || define('POULS_MAX', 100);

defined('GLYCEMIE_MIN') || define('GLYCEMIE_MIN', 0.70);

defined('GLYCEMIE_MAX') || define('GLYCEMIE_MAX', 1.40);

defined('SATURATION_MIN') || define('SATURATION_MIN', 95);

/*
|--------------------------------------------------------------------------
| FORMAT
|--------------------------------------------------------------------------
*/

defined('DATE_FORMAT') || define('DATE_FORMAT', 'd/m/Y');

defined('DATETIME_FORMAT') || define('DATETIME_FORMAT', 'd/m/Y H:i');

/*
|--------------------------------------------------------------------------
| FIN
|--------------------------------------------------------------------------
*/

return true;
