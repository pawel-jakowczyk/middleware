<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use RuntimeException;

final class MiddlewareCollection implements MiddlewareCollectionInterface
{
    private array $middlewares;

    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function count(): int
    {
        return count($this->middlewares);
    }

    public function getFirstMiddleware(): MiddlewareInterface
    {
        return current($this->middlewares) ?: $this->throwEmptyException();
    }

    public function withoutFirst(): self
    {
        $middlewares = $this->middlewares;
        array_shift($middlewares);
        return new self(...$middlewares);
    }

    private function throwEmptyException(): void
    {
        throw new RuntimeException(
            'Middleware collection is empty, please use count method before retrieving from collection'
        );
    }
}