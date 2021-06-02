<?php

declare(strict_types=1);

namespace PJ\Middleware;

final class EmptyMiddlewareFactory implements MiddlewareFactory
{
    public function createMiddlewares(): MiddlewareCollectionInterface
    {
        return new MiddlewareCollection();
    }
}