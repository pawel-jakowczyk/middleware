<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Symfony\Component\Routing\Route;

class MiddlewareRoute extends Route
{
    public function __construct(
        HandlerFactory $handlerFactory,
        MiddlewareFactory $middlewareFactory,
        string $path,
        array $defaults = [],
        array $requirements = [],
        array $options = [],
        ?string $host = '',
        $schemes = [],
        $methods = [],
        ?string $condition = ''
    ) {

        parent::__construct(
            $path,
            array_merge(
                [
                    AttributeNames::HANDLER_FACTORY => $handlerFactory,
                    AttributeNames::MIDDLEWARE_FACTORY => $middlewareFactory,
                ],
                $defaults
            ),
            $requirements,
            $options,
            $host,
            $schemes,
            $methods,
            $condition
        );
    }
}