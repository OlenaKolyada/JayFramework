<?php

namespace App\Exception;

/**
 * Interface HttpExceptionInterface
 *
 * @package App\Exception
 * @author Jérémy GUERIBA
 */
interface HttpExceptionInterface
{
    public function getStatusCode(): int;
}
