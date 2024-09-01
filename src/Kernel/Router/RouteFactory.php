<?php

namespace App\Kernel\Router;

use App\Controller\AbstractController;
use App\View;

/**
 * Class RouteFactory
 *
 * @package App\Kernel\Router
 * @author Jérémy GUERIBA
 */
class RouteFactory
{
    /**
     * @throws Exception\CallbackIsNotCallableException
     */
    public static function createRoute(string $method, string $path, string $callback): Route
    {
        if (class_exists($callback)) {
            if (is_subclass_of($callback, AbstractController::class)) {
                $callable = new $callback(new View());
            } else {
                $callable = new $callback();
            }
        } else {
            $callable = $callback;
        }

        return new Route($method, $path, $callable);
    }
}
