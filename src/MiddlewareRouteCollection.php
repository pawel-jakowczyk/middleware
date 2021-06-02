<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Symfony\Component\Routing\RouteCollection;

class MiddlewareRouteCollection extends RouteCollection
{
    public function __construct(MiddlewareRoute ...$middlewareRoutes)
    {
        array_map(
            fn (MiddlewareRoute $route) => $this->add($route->getName(), $route),
            $middlewareRoutes
        );
    }
}