<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareCollectionInterface
{
    public function count(): int;

    public function getFirstMiddleware(): MiddlewareInterface;

    public function withoutFirst(): self;
}