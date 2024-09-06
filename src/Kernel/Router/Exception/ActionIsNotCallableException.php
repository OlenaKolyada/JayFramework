<?php

namespace App\Kernel\Router\Exception;

use App\Exception\HttpExceptionInterface;
use App\Http\Response;

class ActionIsNotCallableException extends \Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_SERVER_ERROR;
    }
}
