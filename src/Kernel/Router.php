<?php

namespace App\Kernel;

use App\Kernel\Router\Route;

/**
 * Class Router
 *
 * @package App\Kernel
 * @author Jérémy GUERIBA
 */
class Router
{
    private const string DEFAULT_BASE_FILE_PATH = '/index.php';

    private $routes = [];

    /**
     * @throws Router\Exception\CallbackIsNotCallableException
     */
    public function addRoute(string $method, string $path, string|callable $callback): void
    {
        //TODO handle unique route
        $this->routes[] = new Route($method, $path, $callback);
    }

    public function dispatch(string $method, string $uri, string $scriptNamePath): mixed
    {
        $scriptName = $scriptNamePath;
        $basePath = str_replace(self::DEFAULT_BASE_FILE_PATH, '', $scriptName);
        $requestUri = trim(substr($uri, strlen($basePath)), '/');

        /** @var Route $route */
        foreach ($this->routes as $route) {
            $path = trim($route->getPath(), '/');

            // Replace parameters like :id by regexp
            $path = preg_replace('#:([\w]+)#', '([^/]+)', $path);
            $regexp = "#^" . $path . "$#";

            if ($method === $route->getMethod() && preg_match($regexp, $requestUri, $matches)) {
                array_shift($matches); // Retirer la première entrée (l'URL entière)
                return call_user_func_array($route->getCallable(), $matches);
            }
        }

        return null;
    }
}
