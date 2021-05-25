<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class MiddlewareRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middlewareRequest = new MiddlewareRequest($request);
        return $middlewareRequest->countMiddlewares() ?
            $this->processNextMiddleware($middlewareRequest):
            $middlewareRequest->getRequestHandler()->handle($request);
    }

    private function processNextMiddleware(MiddlewareRequest $middlewareRequest): ResponseInterface
    {
        return $middlewareRequest->getFirstMiddleware()->process(
            $middlewareRequest->getRequestWithoutFirstMiddleware(),
            $this
        );
    }
}