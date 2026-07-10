<?php

declare(strict_types=1);

namespace App\Core;

class Session
{
    /**
     * Démarrer la session
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {

            session_start();

        }
    }

    /**
     * Définir une variable de session
     */
    public static function set(
        string $key,
        mixed $value
    ): void
    {
        self::start();

        $_SESSION[$key] = $value;
    }

    /**
     * Lire une variable de session
     */
    public static function get(
        string $key,
        mixed $default = null
    ): mixed
    {
        self::start();

        return $_SESSION[$key] ?? $default;
    }

    /**
     * Vérifier une variable
     */
    public static function has(
        string $key
    ): bool
    {
        self::start();

        return isset($_SESSION[$key]);
    }

    /**
     * Supprimer une variable
     */
    public static function remove(
        string $key
    ): void
    {
        self::start();

        unset($_SESSION[$key]);
    }

    /**
     * Vider la session
     */
    public static function clear(): void
    {
        self::start();

        $_SESSION = [];
    }

    /**
     * Régénérer l'identifiant
     */
    public static function regenerate(): void
    {
        self::start();

        session_regenerate_id(true);
    }

    /**
     * Vérifier si connecté
     */
    public static function isAuthenticated(): bool
    {
        return self::has('user');
    }
        /**
     * Retourne l'utilisateur connecté
     */
    public static function user(): mixed
    {
        return self::get('user');
    }

    /**
     * Connecter un utilisateur
     */
    public static function login(array $user): void
    {
        self::regenerate();

        self::set('user', $user);

        self::set('logged_in', true);

        self::set('login_time', date('Y-m-d H:i:s'));
    }

    /**
     * Déconnecter l'utilisateur
     */
    public static function logout(): void
    {
        self::start();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {

            $params = session_get_cookie_params();

            setcookie(

                session_name(),

                '',

                time() - 42000,

                $params['path'],

                $params['domain'],

                $params['secure'],

                $params['httponly']

            );

        }

        session_destroy();
    }

    /**
     * Retourner toutes les données de session
     */
    public static function all(): array
    {
        self::start();

        return $_SESSION;
    }

    /**
     * Message Flash
     */
    public static function flash(
        string $key,
        mixed $value = null
    ): mixed
    {
        self::start();

        if ($value !== null) {

            $_SESSION['_flash'][$key] = $value;

            return null;

        }

        $message = $_SESSION['_flash'][$key] ?? null;

        unset($_SESSION['_flash'][$key]);

        return $message;
    }

    /**
     * Détruire complètement la session
     */
    public static function destroy(): void
    {
        self::logout();
    }
}