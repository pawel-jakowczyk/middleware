<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @internal
 */
final class MiddlewareRequest
{
    private ServerRequestInterface $request;
    private MiddlewareCollectionInterface $middlewares;
    private RequestHandlerInterface $requestHandler;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->middlewares = $request->getAttribute(AttributeNames::MIDDLEWARES);
        $this->requestHandler = $request->getAttribute(AttributeNames::HANDLER);
    }

    public function countMiddlewares(): int
    {
        return $this->middlewares->count();
    }

    public function getFirstMiddleware(): MiddlewareInterface
    {
        return $this->middlewares->getFirstMiddleware();
    }

    public function getRequestHandler(): RequestHandlerInterface
    {
        return $this->requestHandler;
    }

    public function getRequestWithoutFirstMiddleware(): ServerRequestInterface
    {
        return $this->request->withAttribute(
            AttributeNames::MIDDLEWARES,
            $this->middlewares->withoutFirst()
        );
    }
}