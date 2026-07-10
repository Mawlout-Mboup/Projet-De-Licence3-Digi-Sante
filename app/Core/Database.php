<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {

            $config = require CONFIG_PATH . '/database.php';

            try {

                self::$instance = new PDO(

                    $config['dsn'],

                    $config['username'],

                    $config['password'],

                    $config['options']

                );

            } catch (PDOException $e) {

                die(
                    'Erreur de connexion à la base de données : ' .
                    $e->getMessage()
                );

            }

        }

        return self::$instance;
    }

    public static function disconnect(): void
    {
        self::$instance = null;
    }
}