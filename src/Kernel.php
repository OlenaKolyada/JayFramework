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
 * Initialize and launch the app
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
        // As we handle response header, we don't want anything to be printed before. So every prints are put in a buffer
        // Content will be printed at request ends
        ob_start();

        try {
            // Initialize routing system
            self::launchRouting();
            // Route system is initialized now we dispatch the process
            self::dispatch();
        } catch (HttpExceptionInterface $e) {
            // Here we handle our custom exception to handle response header according to what we plan
            self::displayError($e->getStatusCode(), $e);
        } catch (\Exception $e) {
            // Here we handle not catched exception that are not app custom ones. By default we send a response with 500 status code
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

        //Load route configuration in a config file. It's better this way than to write routes in the code
        $configuredRoutes = self::loadConfig('routes');
        //We check if routes key exists in yaml file
        $routes = $configuredRoutes['routes'] ?? null;

        // If there is no route configured, the thrown exceptions will be used to send a 500 status code in the response
        if (empty($routes)) {
            throw new NoAvailableRouteException("No routes has been defined");
        }

        // Load routes in memory
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
        // Router handle the request uri, find the right action to execute and return the content produced by it
        $result = self::$router->dispatch(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_SERVER['SCRIPT_NAME']
        );
        //Now everything is handled, we just need to send the response
        ob_end_clean();

        if ($result instanceof Response) {
            // We define content type. It tells to client if he is receiving html, json or a file to download for example
            header('Content-Type: ' . $result->getContentType());
            // Here we define the response status.
            http_response_code($result->getStatusCode());
            // Now we print the generated content in the response, this is the content that client will receive
            echo $result->getContent();
        } else if (is_string($result)) {
            echo $result;
        } else {
            // In case the generated content is not an expected type, we throw an exception. This part can be improved.
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
