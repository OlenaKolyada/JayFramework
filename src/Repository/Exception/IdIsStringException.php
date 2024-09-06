<?php

declare(strict_types=1);

namespace App\Repository\Exception;
use App\Exception\HttpExceptionInterface;
use App\Http\Response;

class IdIsStringException  extends \Exception implements HttpExceptionInterface
{

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}