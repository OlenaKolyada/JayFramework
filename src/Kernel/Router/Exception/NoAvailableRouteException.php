<?php

namespace App\Kernel\Router\Exception;

use App\Exception\HttpExceptionInterface;
use App\Http\Response;

/**
 * Class NoAvailableRouteException
 *
 * An exception thrown when no route is available.
 * Handle by kernel to set status code to 500 in response headers
 *
 * @package App\Kernel\Router\Exception
 * @author Jérémy GUERIBA
 */
class NoAvailableRouteException extends \Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_SERVER_ERROR;
    }
}
