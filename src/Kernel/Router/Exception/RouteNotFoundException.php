<?php

namespace App\Kernel\Router\Exception;

use App\Exception\HttpExceptionInterface;
use App\Http\Response;

/**
 * Class RouteNotFoundException
 *
 * @package App\Kernel\Router\Exception
 * @author Jérémy GUERIBA
 */
class RouteNotFoundException extends \Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
