<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            "method" => $method,
            "path" => $path,
            "controller" => $controller,
            "action" => $action
        ];
    }

    public function dispatch() {
        $method = $_SERVER["REQUEST_METHOD"];
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        
        // Enlever le préfixe du dossier si nécessaire
        $prefix = "/gestio3";
        if (strpos($uri, $prefix) === 0) {
            $uri = substr($uri, strlen($prefix));
        }

        foreach ($this->routes as $route) {
            if ($route["method"] === $method && $this->matchPath($route["path"], $uri)) {
                $controller = new $route["controller"]();
                call_user_func([$controller, $route["action"]]);
                return;
            }
        }

        // Route non trouvée
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }

    private function matchPath($routePath, $uri) {
        $pattern = preg_replace("/\{([a-zA-Z]+)\}/", "(?P<\\\\1>[^/]+)", $routePath);
        $pattern = "#^" . $pattern . "$#";
        
        if (preg_match($pattern, $uri, $matches)) {
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $_GET[$key] = $value;
                }
            }
            return true;
        }
        return false;
    }
}
