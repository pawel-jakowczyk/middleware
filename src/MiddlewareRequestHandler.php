<?php

namespace pj\middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class MiddlewareRequestHandler implements RequestHandlerInterface
{
    public const MIDDLEWARES_ATTRIBUTE_NAME = 'middlewares';

    private RequestHandlerInterface $finalRequestHandler;

    public static function create(): self
    {
        return new self(new EmptyResponseRequestHandler());
    }

    public function __construct(RequestHandlerInterface $finalRequestHandler)
    {
        $this->finalRequestHandler = $finalRequestHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middlewares = $request->getAttribute(self::MIDDLEWARES_ATTRIBUTE_NAME);
        $middleware = $this->getCurrentMiddleware($middlewares);
        $request->withAttribute(
            self::MIDDLEWARES_ATTRIBUTE_NAME,
            $middlewares->withoutCurrent()
        );
        return $middleware ?
            $middleware->process($request, $this) :
            $this->finalRequestHandler->handle($request);
    }

    private function getCurrentMiddleware(MiddlewareCollectionInterface $middlewareCollection)
    {
        return $middlewareCollection->getIterator()->current();
    }
}