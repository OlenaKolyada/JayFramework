<?php

namespace App\Kernel\Router;

use App\Controller\AbstractController;
use App\Kernel\Router\Exception\ActionIsNotCallableException;
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
     * Фабрика для создания маршрутор
     * Создает объект Route с заданными параметрами
     * @throws ActionIsNotCallableException
     */
    public static function createRoute(string $method, string $uri, string $controller): Route
    {
        if (class_exists($controller) && is_subclass_of($controller, AbstractController::class)) {
                $view = new View();
                $action = new $controller($view);

        } else {
                $action = new $$controller();
        }


        return new Route($method, $uri, $action);
    }
}
