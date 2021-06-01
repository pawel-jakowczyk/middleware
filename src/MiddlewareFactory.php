<?php

declare(strict_types=1);

namespace PJ\Middleware;

interface MiddlewareFactory
{
    public function createMiddlewares(): MiddlewareCollectionInterface;
}