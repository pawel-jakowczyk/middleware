<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class MiddlewareFactoryRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return (new MiddlewareRequestHandler())->handle(
            $request->withAttribute(
                AttributeNames::MIDDLEWARES,
                $this->getMiddlewareFactoryFromRequest($request)->createMiddlewares()
            )->withAttribute(
                AttributeNames::HANDLER,
                $this->getHandlerFactoryFromRequest($request)->createRequestHandler()
            )
        );
    }

    private function getHandlerFactoryFromRequest(ServerRequestInterface $request): HandlerFactory
    {
        return $request->getAttribute(AttributeNames::HANDLER_FACTORY);
    }

    private function getMiddlewareFactoryFromRequest(ServerRequestInterface $request): MiddlewareFactory
    {
        return $request->getAttribute(AttributeNames::MIDDLEWARE_FACTORY);
    }
}