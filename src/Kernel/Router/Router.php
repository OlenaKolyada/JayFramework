<?php

namespace App\Kernel\Router;

use App\Http\Response;
use App\Kernel\Router\Exception\ActionIsNotCallableException;
use App\Kernel\Router\Exception\RouteNotFoundException;

/**
 * Class Router
 *
 * @package App\Kernel
 * @author Jérémy GUERIBA
 */
class Router
{
    // Константа для определения пути к базовому файлу по умолчанию
    private const string DEFAULT_BASE_FILE_PATH = '/index.php';

    // Массив для хранения маршрутов
    private array $routes = [];

    /**
     * Загружает маршруты из конфигурационного массива, полученного из routes
     * .yaml и создает массив маршрутов, который содержит объекты класса Route
     *
     * @param array $routes
     * @throws ActionIsNotCallableException
     */
    public function loadRoutes(array $routes): void
    {
        // Проходим по всем маршрутам из конфигурации
        foreach ($routes as $uri => $routeParams) {
            // Извлекаем метод и вызываемую функцию из конфигурации маршрута
            $method = $routeParams['method'];
            $controller = $routeParams['controller'];

            // Создаём объект маршрута Route с помощью фабрики
            $route = RouteFactory::createRoute($method, $uri, $controller);

            // Добавляем объект Route в массив маршрутов
            $this->routes[] = $route;
        }
    }

    /**
     * Диспетчеризирует запрос, сопоставляя метод и URI с маршрутами
     *
     * @throws RouteNotFoundException
     */
    public function handleRequest(string $method, string $uri, string $fileName): mixed
    {
        // Определяем базовый путь из имени скрипта, удаляя базовый файл
        $basePath = str_replace(self::DEFAULT_BASE_FILE_PATH, '', $fileName);

        // Убираем базовый путь из URI, очищаем строку от начальных и конечных слэшей
        $finalUri = trim(substr($uri, strlen($basePath)), '/');

        // Проходим по всем маршрутам для поиска подходящего
        foreach ($this->routes as $route) {

            // Получаем путь из маршрута и убираем начальные и конечные слэши
            $path = trim($route->getUri(), '/');

            // Заменяем параметры вида :id на регулярное выражение
            $path = preg_replace('#:([\w]+)#', '([^/]+)', $path);

            // Создаём регулярное выражение для проверки пути
            $regexp = "#^" . $path . "$#";

            // Проверяем, соответствует ли метод и URI маршруту с помощью регэкспа
            $isMethodMatch = $method === $route->getMethod();

            // $matches - массив, в который функция кладет совпадиния
            $isUriMatch = preg_match($regexp, $finalUri, $matches);

            // Если и метод, и URI совпадают
            if ($isMethodMatch && $isUriMatch) {
                // Убираем первый элемент из массива совпадений (он содержит полный путь)
                array_shift($matches);

                // Получаем вызываемую функцию из маршрута
                $action = $route->getAction();

                // Вызываем выполнение соответствующего контроллера Action
                $response = call_user_func_array($action, $matches); // Возвращается объект Response
                return $response;
            }
        }

        // Если не найден подходящий маршрут, выбрасываем исключение
        throw new RouteNotFoundException('Route not found');
    }
}
