<?php

namespace App\Repository\Exception;

use App\Exception\HttpExceptionInterface;
use App\Http\Response;

/**
 * Class ItemNotFoundException
 *
 * @package App\Repository\Exception
 * @author Jérémy GUERIBA
 */
class ItemNotFoundException extends \Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
