<?php

namespace App\Kernel;

use App\Kernel\Router\Exception\RouteNotFoundException;
use App\Kernel\Router\Route;
use App\Kernel\Router\RouteFactory;

/**
 * Class Router
 *
 * @package App\Kernel
 * @author Jérémy GUERIBA
 */
class Router
{
    private const string DEFAULT_BASE_FILE_PATH = '/index.php';

    private array $routes = [];

    /**
     * @throws Router\Exception\CallbackIsNotCallableException
     */
    public function addRoute(Route $route): void
    {
        //TODO handle unique route
        $this->routes[] = $route;
    }

    /**
     * @throws Router\Exception\CallbackIsNotCallableException
     */
    public function loadFromConfigData(array $definedRoutes): void
    {
        // We loop on every defined routes in config
        foreach ($definedRoutes as $uri => $routeConfiguration) {
            // For each defined route, we create a route object that will be used to match request URI and launch the right controller
            // Every created route are stored in an array
            $this->addRoute(RouteFactory::createRoute(
                $routeConfiguration['method'],
                $uri,
                $routeConfiguration['callable']
            ));
        }
    }

    /**
     * @throws RouteNotFoundException
     */
    public function dispatch(string $method, string $uri, string $scriptNamePath): mixed
    {
        // Here we handle the script name path. We need to do this to handle the rewrited url, cause every url will leads to the index file in public folder
        $scriptName = $scriptNamePath;
        $basePath = str_replace(self::DEFAULT_BASE_FILE_PATH, '', $scriptName);
        //here we handle specific environment path. For example, the uri is not the same locally with no sub domain then in production were domain without path leads to the public/index.php
        $requestUri = trim(substr($uri, strlen($basePath)), '/');

        /** @var Route $route */
        foreach ($this->routes as $route) {
            $path = trim($route->getPath(), '/');

            //We build dynamically a regexp to match the requested uri with defined route
            // Replace parameters like :id by regexp
            $path = preg_replace('#:([\w]+)#', '([^/]+)', $path);
            $regexp = "#^" . $path . "$#";

            // For each route we match if request method match route method and if request uri match the defined route uri
            // As some parameters can be set in the route, thats why we build $regexp dynamicaly, to replace all defined route uri masks (:id for example)
            // by a regexp pattern to be able to match the request uri
            if ($method === $route->getMethod() && preg_match($regexp, $requestUri, $matches)) {
                array_shift($matches); // Remove first unusable match
                //call_user_func_array call the controller defined in the route that match request uri
                return call_user_func_array($route->getCallable(), $matches);
            }
        }

        // If no route is found, we throws the exception to return a 404 status code. The kernel handle an error view in error cases
        throw new RouteNotFoundException('Route not found');
    }
}
