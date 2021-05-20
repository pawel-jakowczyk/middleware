<?php

namespace pj\middleware;

use Psr\Http\Server\MiddlewareInterface;
use IteratorAggregate;
use Generator;

class MiddlewareCollection implements IteratorAggregate
{
    private MiddlewareInterface $middlewares;

    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function getIterator(): Generator
    {
        yield from $middewares;
    }

    public function withoutCurrent(): self
    {
        array_pop($this->middlewares);
        return self(...$this->middlewares);
    }
}