<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Symfony\Component\Routing\Route;

final class MiddlewareRoute extends Route
{
    private string $name;

    public function __construct(
        string $name,
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
        $this->name = $name;
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

    public function getName(): string
    {
        return $this->name;
    }
}