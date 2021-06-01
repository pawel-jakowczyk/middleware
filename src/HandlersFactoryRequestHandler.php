<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HandlersFactoryRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $factory = $this->getFactoryFromRequest($request);
        return (new MiddlewareRequestHandler())->handle(
            $request->withAttribute(
                AttributeNames::MIDDLEWARES,
                $factory->createMiddlewares()
            )->withAttribute(
                AttributeNames::HANDLER,
                $factory->createRequestHandler()
            )
        );
    }

    private function getFactoryFromRequest(ServerRequestInterface $request): HandlersFactory
    {
        return $request->getAttribute(AttributeNames::HANDLERS_FACTORY);
    }
}