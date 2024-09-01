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
        ob_start();

        try {
            self::launchRouting();
            self::dispatch();
        } catch (HttpExceptionInterface $e) {
            self::displayError($e->getStatusCode(), $e);
        } catch (\Exception $e) {
            self::displayError(Response::HTTP_SERVER_ERROR, $e);
        }
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

    /**
     * @throws Router\Exception\RouteNotFoundException
     * @throws \Exception
     */
    private static function dispatch(): void
    {
        $result = self::$router->dispatch(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_SERVER['SCRIPT_NAME']
        );

        ob_end_clean();

        if ($result instanceof Response) {
            header('Content-Type: ' . $result->getContentType());
            http_response_code($result->getStatusCode());

            echo $result->getContent();
        } else if (is_string($result)) {
            echo $result;
        } else {
            throw new \Exception('Something went wrong');
        }
    }

    private static function displayError(int $statusCode, \Exception $e): void
    {
        header('Content-Type: ' . Response::CONTENT_TYPE_HTML);
        http_response_code($statusCode);
        include View::TEMPLATE_BASE_PATH . 'error.html.php';
    }
}
