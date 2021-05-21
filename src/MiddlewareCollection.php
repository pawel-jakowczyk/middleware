<?php

namespace pj\middleware;

use Psr\Http\Server\MiddlewareInterface;
use Generator;

final class MiddlewareCollection implements MiddlewareCollectionInterface
{
    private array $middlewares;

    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function getIterator(): Generator
    {
        yield from $this->middlewares;
    }

    public function withoutCurrent(): self
    {
        array_pop($this->middlewares);
        return new self(...$this->middlewares);
    }
}