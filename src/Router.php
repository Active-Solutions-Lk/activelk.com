<?php
declare(strict_types=1);

namespace Src;

class Router {
    private array $routes;

    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    public function dispatch(Request $req): Response {
        $reqMethod = $req->method();
        $reqPath   = $req->path();

        foreach ($this->routes as $route) {
            [$method, $pattern, $target, $action] = $route;
            if ($method !== $reqMethod) continue;

            $params = $this->match($pattern, $reqPath);
            if ($params !== false) {
                // Prepend App\Controllers\ if not fully qualified
                $controllerClass = strpos($target, '\\') !== false ? $target : "App\\Controllers\\{$target}";
                
                if (!class_exists($controllerClass)) {
                    $res = new Response();
                    return $res->setContent("Controller [{$controllerClass}] not found.")->setStatus(500);
                }

                $controller = new $controllerClass();
                if (!method_exists($controller, $action)) {
                    $res = new Response();
                    return $res->setContent("Action [{$action}] on controller [{$controllerClass}] not found.")->setStatus(500);
                }

                $result = $controller->$action($req, $params);
                if ($result instanceof Response) {
                    return $result;
                }
                
                $res = new Response();
                return $res->setContent((string)$result);
            }
        }

        $res = new Response();
        return $res->view('errors/404', [], 404);
    }

    private function match(string $pattern, string $path) {
        $regex = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';

        if (preg_match($regex, $path, $matches)) {
            $params = [];
            foreach ($matches as $k => $v) {
                if (is_string($k)) {
                    $params[$k] = $v;
                }
            }
            return $params;
        }

        return false;
    }
}
