<?php

namespace App;

use App\Controller\IndexAction;
use App\Kernel\Router;

/**
 * Class Kernel
 *
 * @package App
 * @author Jérémy GUERIBA
 */
class Kernel
{
    public static function run(): void
    {
        self::initRoutes();
    }

    /**
     * @throws Router\Exception\CallbackIsNotCallableException
     */
    private static function initRoutes(): void
    {
        $router = new Router();
        $router->addRoute('GET', '/', new IndexAction());

        $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']);
    }
}
