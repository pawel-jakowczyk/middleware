<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Server\RequestHandlerInterface;

interface HandlersFactory
{
    public function createMiddlewares(): MiddlewareCollectionInterface;

    public function createRequestHandler(): RequestHandlerInterface;
}