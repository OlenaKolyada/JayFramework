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
        // If the route we want to create leads to a class
        if (class_exists($callback)) {
            // If the target class extends our abastract controller, we create an instance of the controller with the expected view object in constructor
            if (is_subclass_of($callback, AbstractController::class)) {
                $callable = new $callback(new View());
            } else {
                // Otherwise, we assume that target class constructor is empty
                // We can go more complex with some reflection but it's way more complicated
                $callable = new $callback();
            }
        } else {
            // If we don't handle a class we assume we already have a callable. This part should be improved, unusable with this implementation
            $callable = $callback;
        }

        // We can create and return our route instance
        return new Route($method, $path, $callable);
    }
}
