<?php

namespace App\Kernel;

use App\Exception\HttpExceptionInterface;
use App\Http\Response;
use APP\Kernel\Router\Exception\NoAvailableRouteException;
use App\Kernel\Router\Router;
use App\View;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Kernel
 *
 * @package App
 * @author Jérémy GUERIBA
 */
class Kernel
{
    // Константа для корневого каталога приложения - папки JayFramework/
    public const string APP_ROOT_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

    // Константа для каталога конфигурации приложения - JayFramework/config/
    public const string APP_CONFIG_DIR = self::APP_ROOT_DIR . 'config' . DIRECTORY_SEPARATOR;

    // Статическая переменная для роутера (маршрутизатора)
    private static Router $router;



    public static function run(): void
    {
        ob_start(); // Начало буферизации вывода

        try {
            // Инициализация роутера
            self::$router = new Router();

            // Загрузка маршрутов. Парсинг YAML-файла
            $routesFromYaml = Yaml::parseFile(self::APP_CONFIG_DIR . 'routes' . '.yaml');

            // Эта строка помогает безопасно извлечь маршруты из YAML-файла, не вызывая ошибок, если ключ 'routes' вдруг отсутствует. Это предотвращает потенциальную ошибку доступа к несуществующему элементу массива. В случае отсутствия маршрутов будет сгенерировано исключение, которое обрабатывается дальше в коде
            $routes = $routesFromYaml['routes'] ?? null;

            if (empty($routes)) {
                throw new NoAvailableRouteException("No routes has been defined");
            }

            // Загрузка маршрутов в маршрутизатор, чтобы создать массив маршрутов
            self::$router->loadRoutes($routes);

            // Обработка маршрута и вызов соответствующего контроллера (Action)
            $result = self::$router->handleRequest( // Диспетчеризация запроса
                $_SERVER['REQUEST_METHOD'], // HTTP метод запроса
                $_SERVER['REQUEST_URI'], // URI запроса
                $_SERVER['SCRIPT_NAME'] // Имя файла
            );

            ob_end_clean(); // Очистка буфера вывода

            if ($result instanceof Response) { // Если результат является объектом Response
                // Получаем тип содержимого из результата
                $contentType = $result->getContentType(); // Получение типа содержимого

                // Устанавливаем заголовок Content-Type
                header('Content-Type: ' . $contentType);

                // Получаем код статуса из результата
                $statusCode = $result->getStatusCode(); // Получение кода статуса

                // Устанавливаем код ответа HTTP
                http_response_code($statusCode);

                // Вывод содержимого результата
                echo $result->getContent();

            } else if (is_string($result)) { // Если результат является строкой
                echo $result; // Вывод строки

            } else { // Если результат не является ни объектом Response, ни строкой
                throw new \Exception('Something went wrong'); // Генерация исключения
            }

        } catch (HttpExceptionInterface $e) { // Обработка исключений HTTP
            $statusCode = $e->getStatusCode(); // Получение кода статуса ошибки
            self::displayError($statusCode, $e); // Отображение ошибки

        } catch (\Exception $e) { // Обработка общих исключений
            self::displayError(Response::HTTP_SERVER_ERROR, $e); // Отображение ошибки сервера
        }
    }

    /**
     * Отображение страницы ошибки
     *
     * @param int $statusCode Код статуса ошибки
     * @param \Exception $e Исключение
     */
    private static function displayError(int $statusCode, \Exception $e): void
    {
        header('Content-Type: ' . Response::CONTENT_TYPE_HTML); // Установка заголовка Content-Type для HTML
        http_response_code($statusCode); // Установка кода ответа HTTP
        include View::TEMPLATE_BASE_PATH . 'error.html.php'; // Подключение шаблона страницы ошибки
    }

}
