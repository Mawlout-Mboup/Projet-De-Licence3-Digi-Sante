<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| ENVIRONNEMENT
|--------------------------------------------------------------------------
*/

defined('DB_ENV') || define('DB_ENV', (string) env_value('DB_ENV', APP_ENV));

/*
|--------------------------------------------------------------------------
| CONFIGURATION
|--------------------------------------------------------------------------
*/

$config = [

    'driver' => (string) env_value('DB_DRIVER', 'mysql'),

    'host' => (string) env_value('DB_HOST', '127.0.0.1'),

    'port' => (int) env_value('DB_PORT', 3306),

    'database' => (string) env_value('DB_NAME', 'digi_sante'),

    'username' => (string) env_value('DB_USER', 'root'),

    'password' => (string) env_value('DB_PASS', ''),

    'charset' => (string) env_value('DB_CHARSET', 'utf8mb4')

];

$config['dsn'] =

    "{$config['driver']}:host={$config['host']};" .

    "port={$config['port']};" .

    "dbname={$config['database']};" .

    "charset={$config['charset']}";

$config['options'] = [

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

    PDO::ATTR_EMULATE_PREPARES => false

];

return $config;
