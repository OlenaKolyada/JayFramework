<?php

namespace App\Kernel\Router;

use App\Kernel\Router\Exception\ActionIsNotCallableException;

/**
 * Class Route
 *
 * @package App\Kernel\Router
 * @author Jérémy GUERIBA
 */
readonly class Route implements RouteInterface
{
    /**
     * @throws ActionIsNotCallableException
     */
    public function __construct(
        private string $method,
        private string $uri,
        private mixed $action
    )
    {
        if (!is_callable($this->action)) {
            throw new ActionIsNotCallableException("action is not callable");
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAction(): callable
    {
        return $this->action;
    }
}
