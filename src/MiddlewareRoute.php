<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Symfony\Component\Routing\Route;

class MiddlewareRoute extends Route
{
    public function __construct(
        HandlersFactory $handlersFactory,
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
            array_merge([AttributeNames::HANDLERS_FACTORY => $handlersFactory], $defaults),
            $requirements,
            $options,
            $host,
            $schemes,
            $methods,
            $condition
        );
    }
}