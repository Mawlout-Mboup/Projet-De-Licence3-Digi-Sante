<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    /**
     * Routes GET
     */
    private array $getRoutes = [];

    /**
     * Routes POST
     */
    private array $postRoutes = [];

    /**
     * Routes PUT
     */
    private array $putRoutes = [];

    /**
     * Routes DELETE
     */
    private array $deleteRoutes = [];

    /**
     * Constructeur
     */
    public function __construct()
    {
    }

    /**
     * Enregistrer une route GET
     */
    public function get(string $uri, $action): void
    {
        $this->getRoutes[$this->normalize($uri)] = $action;
    }

    /**
     * Enregistrer une route POST
     */
    public function post(string $uri, $action): void
    {
        $this->postRoutes[$this->normalize($uri)] = $action;
    }

    /**
     * Enregistrer une route PUT
     */
    public function put(string $uri, $action): void
    {
        $this->putRoutes[$this->normalize($uri)] = $action;
    }

    /**
     * Enregistrer une route DELETE
     */
    public function delete(string $uri, $action): void
    {
        $this->deleteRoutes[$this->normalize($uri)] = $action;
    }

    /**
     * Retourne toutes les routes
     */
    public function routes(): array
    {
        return [

            'GET' => $this->getRoutes,

            'POST' => $this->postRoutes,

            'PUT' => $this->putRoutes,

            'DELETE' => $this->deleteRoutes

        ];
    }

    /**
     * Nettoyage des URLs
     */
    private function normalize(string $uri): string
    {
        $uri = trim($uri);

        if ($uri === '') {
            return '/';
        }

        $uri = '/' . trim($uri, '/');

        return $uri;
    }

    /**
     * URI actuelle
     */
    private function currentUri(): string
    {
        $uri = parse_url(

            $_SERVER['REQUEST_URI'],

            PHP_URL_PATH

        );

        $base = defined('BASE_PATH') ? BASE_PATH : '';

        if ($base !== '' && str_starts_with($uri, $base)) {

            $uri = substr($uri, strlen($base));

        }

        return $this->normalize($uri);
    }
        /**
     * Méthode HTTP actuelle
     */
    private function currentMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * Retourne les routes selon la méthode
     */
    private function getRouteCollection(string $method): array
    {
        return match ($method) {

            'GET'    => $this->getRoutes,

            'POST'   => $this->postRoutes,

            'PUT'    => $this->putRoutes,

            'DELETE' => $this->deleteRoutes,

            default  => []

        };
    }

    /**
     * Exécution du routeur
     */
    public function dispatch(): void
    {
        $method = $this->currentMethod();

        $uri = $this->currentUri();

        $routes = $this->getRouteCollection($method);

        if (!array_key_exists($uri, $routes)) {

            $this->notFound();

            return;

        }

        $action = $routes[$uri];

        $this->execute($action);

    }

    /**
     * Exécuter une action
     */
    private function execute($action): void
    {

        if (is_callable($action)) {

            call_user_func($action);

            return;

        }

        if (is_string($action)) {

            if (!str_contains($action, '@')) {

                throw new \Exception(
                    "Route invalide : {$action}"
                );

            }

            [$controller, $method] = explode('@', $action);

            $class = "App\\Controllers\\{$controller}";

            if (!class_exists($class)) {

                throw new \Exception(
                    "Contrôleur {$controller} introuvable."
                );

            }

            $instance = new $class();

            if (!method_exists($instance, $method)) {

                throw new \Exception(
                    "Méthode {$method} inexistante."
                );

            }

            call_user_func([$instance, $method]);

            return;

        }

        throw new \Exception(
            "Action de route invalide."
        );

    }
        /**
     * Redirection
     */
    public function redirect(string $uri): void
    {
        $uri = $this->normalize($uri);

        header('Location: ' . BASE_URL . $uri);

        exit;
    }

    /**
     * Page 404
     */
    private function notFound(): void
    {
        http_response_code(404);

        $view = VIEW_PATH . '/errors/404.php';

        if (file_exists($view)) {

            require $view;

        } else {

            echo "<!DOCTYPE html>";
            echo "<html lang='fr'>";
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<title>404</title>";
            echo "<style>
                    body{
                        font-family:Arial,sans-serif;
                        background:#f5f5f5;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                        height:100vh;
                        margin:0;
                    }
                    .box{
                        text-align:center;
                    }
                    h1{
                        font-size:70px;
                        color:#dc3545;
                        margin:0;
                    }
                    p{
                        color:#555;
                        font-size:18px;
                    }
                  </style>";
            echo "</head>";
            echo "<body>";
            echo "<div class='box'>";
            echo "<h1>404</h1>";
            echo "<p>Page introuvable.</p>";
            echo "</div>";
            echo "</body>";
            echo "</html>";

        }

        exit;
    }

    /**
     * Vérifie l'existence d'une route GET
     */
    public function hasGet(string $uri): bool
    {
        return isset(
            $this->getRoutes[
                $this->normalize($uri)
            ]
        );
    }

    /**
     * Vérifie l'existence d'une route POST
     */
    public function hasPost(string $uri): bool
    {
        return isset(
            $this->postRoutes[
                $this->normalize($uri)
            ]
        );
    }

    /**
     * Nombre total de routes
     */
    public function count(): int
    {
        return

            count($this->getRoutes)

            + count($this->postRoutes)

            + count($this->putRoutes)

            + count($this->deleteRoutes);

    }

}
