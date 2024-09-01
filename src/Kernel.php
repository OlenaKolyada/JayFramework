<?php

namespace App;

use App\Controller\IndexAction;
use App\Controller\NewsCollectionAction;
use App\Controller\NewsItemAction;
use App\Kernel\Router;
use APP\Kernel\Router\Exception\NoAvailableRouteException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Kernel
 *
 * @package App
 * @author Jérémy GUERIBA
 */
class Kernel
{
    public const string APP_ROOT_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
    public const string APP_CONFIG_DIR = self::APP_ROOT_DIR . 'config' . DIRECTORY_SEPARATOR;

    private static Router $router;

    public static function run(): void
    {
        self::launchRouting();
    }

    /**
     * @throws NoAvailableRouteException
     * @throws Router\Exception\CallbackIsNotCallableException
     */
    private static function launchRouting(): void
    {
        self::$router = new Router();

        $configuredRoutes = self::loadConfig('routes');
        $routes = $configuredRoutes['routes'] ?? null;

        if (empty($routes)) {
            throw new NoAvailableRouteException("No routes found");
        }

        foreach ($routes as $uri => $routeConfiguration) {
            $callable = class_exists($routeConfiguration['callable']) ? new $routeConfiguration['callable']() : $routeConfiguration['callable'];
            self::$router->addRoute($routeConfiguration['method'], $uri, $callable);
        }

        self::$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']);
    }

    private static function loadConfig(string $configFile): array
    {
        return Yaml::parseFile(self::APP_CONFIG_DIR . $configFile . '.yaml');
    }
}
