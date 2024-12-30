<?php

namespace Kasl\KaslFw\Core;

class Router
{
    protected $routes = [];
    protected $middlewares = [];

    public function register($method, $route, $action)
    {
        $this->routes[$method][$route] = $action;
    }

    public function addMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes[$method] as $route => $action) {
            $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([a-zA-Z0-9_-]+)', $route);

            if (preg_match("#^{$pattern}$#", $uri, $matches)) {
                array_shift($matches); // Remove the full match

                // Create a basic request object
                $request = (object) [
                    'params' => $matches,
                    'method' => $method,
                    'uri'    => $uri,
                ];

                // Pass the request object through the middleware stack
                return call_user_func($this->createMiddlewareStack($action), $request);
            }
        }

        http_response_code(404);
        return "404 Not Found";
    }

    protected function createMiddlewareStack($controllerAction)
    {
        $stack = function ($request) use ($controllerAction) {
            if (is_callable($controllerAction)) {
                return call_user_func($controllerAction, $request);
            }

            if (is_array($controllerAction)) {
                list($class, $method) = $controllerAction;
                if (class_exists($class) && method_exists($class, $method)) {
                    $controllerInstance = new $class();
                    return call_user_func([$controllerInstance, $method], $request);
                } else {
                    http_response_code(500);
                    return "500 Internal Server Error: Controller or method not found.";
                }
            }

            return "500 Internal Server Error: Invalid controller action.";
        };

        return array_reduce(array_reverse($this->middlewares), function ($next, $middleware) {
            return function ($request) use ($next, $middleware) {
                return $middleware->handle($request, $next);
            };
        }, $stack);
    }
}
