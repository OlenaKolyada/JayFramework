<?php

namespace App\Kernel\Router;

/**
 * Interface RouteInterface
 *
 * @package App\Kernel\Router
 * @author Jérémy GUERIBA
 */
interface RouteInterface
{
    public function getMethod(): string;
    public function getUri(): string;
    public function getAction(): callable;
}
