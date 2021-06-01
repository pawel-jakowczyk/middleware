<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Server\RequestHandlerInterface;

interface HandlerFactory
{
    public function createRequestHandler(): RequestHandlerInterface;
}