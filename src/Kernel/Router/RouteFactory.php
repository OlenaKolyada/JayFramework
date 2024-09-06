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
    public static function createRoute(string $method, string $uri, string $action): Route
    {
        if (class_exists($action) && is_subclass_of($action, AbstractController::class)) {
                $view = new View();
                $actionInstance = new $action($view);

        } else {
                $actionInstance = new $action();
        }


        return new Route($method, $uri, $actionInstance);
    }
}
