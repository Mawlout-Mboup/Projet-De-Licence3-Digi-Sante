<?php

/**
 * ============================================================
 * DIGI-SANTE
 * ------------------------------------------------------------
 * Point d'entrée principal de l'application
 * Architecture MVC Native PHP 8
 * ============================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| DÉMARRAGE DE LA SESSION
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| CHARGEMENT DE LA CONFIGURATION
|--------------------------------------------------------------------------
*/

require_once dirname(__DIR__) . '/config/config.php';
require_once CONFIG_PATH . '/database.php';

/*
|--------------------------------------------------------------------------
| AUTOLOADER PSR-4
|--------------------------------------------------------------------------
*/

spl_autoload_register(function ($class) {

    $prefix = 'App\\';
    $baseDir = APP_PATH . '/';

    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);

    $file = $baseDir .
        str_replace('\\', '/', $relativeClass) .
        '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

$helpers = [
    HELPER_PATH . '/functions.php',
    HELPER_PATH . '/security.php',
    HELPER_PATH . '/pdf.php'
];

foreach ($helpers as $helper) {

    if (file_exists($helper)) {
        require_once $helper;
    }
}

/*
|--------------------------------------------------------------------------
| GESTION DES ERREURS
|--------------------------------------------------------------------------
*/

set_exception_handler(function (Throwable $exception) {

    http_response_code(500);

    echo "<h1>Digi-Santé</h1>";
    echo "<h2>Erreur interne</h2>";

    if (APP_ENV === 'development') {

        echo "<pre>";
        echo $exception;
        echo "</pre>";

    }

    exit;
});

set_error_handler(function (
    int $severity,
    string $message,
    string $file,
    int $line
) {

    throw new ErrorException(
        $message,
        0,
        $severity,
        $file,
        $line
    );
});

/*
|--------------------------------------------------------------------------
| CRÉATION DES DOSSIERS
|--------------------------------------------------------------------------
*/

$directories = [

    STORAGE_PATH,

    LOG_PATH,

    PDF_PATH,

    UPLOAD_PATH

];

foreach ($directories as $directory) {

    if (!is_dir($directory)) {

        mkdir($directory, 0777, true);

    }
}

/*
|--------------------------------------------------------------------------
| CHARGEMENT DU ROUTEUR
|--------------------------------------------------------------------------
*/

use App\Core\Router;

/*
|--------------------------------------------------------------------------
| CREATION DU ROUTEUR
|--------------------------------------------------------------------------
*/

$router = new Router();

/*
|--------------------------------------------------------------------------
| CHARGEMENT DES ROUTES
|--------------------------------------------------------------------------
*/

require_once ROUTES_PATH . '/web.php';

/*
|--------------------------------------------------------------------------
| EXECUTION
|--------------------------------------------------------------------------
*/

$router->dispatch();