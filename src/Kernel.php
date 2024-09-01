<?php

namespace App;

use App\Exception\HttpExceptionInterface;
use App\Http\Response;
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

    /**
     * @throws NoAvailableRouteException
     * @throws Router\Exception\CallbackIsNotCallableException
     * @throws Router\Exception\RouteNotFoundException
     */
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
            throw new NoAvailableRouteException("No routes has been defined");
        }

        self::$router->loadFromConfigData($routes);
    }

    private static function loadConfig(string $configFile): array
    {
        return Yaml::parseFile(self::APP_CONFIG_DIR . $configFile . '.yaml');
    }
}
