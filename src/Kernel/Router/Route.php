<?php

namespace App\Kernel\Router;

use App\Kernel\Router\Exception\CallbackIsNotCallableException;

/**
 * Class Route
 *
 * @package App\Kernel\Router
 * @author Jérémy GUERIBA
 */
readonly class Route implements RouteInterface
{
    /**
     * @throws CallbackIsNotCallableException
     */
    public function __construct(
        private string $method,
        private string $path,
        private mixed $callback
    )
    {
        if (!is_callable($this->callback)) {
            throw new CallbackIsNotCallableException("callback property is not callable");
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCallable(): callable
    {
        return $this->callback;
    }
}
