<?php

declare(strict_types=1);

namespace PJ\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

const HANDLERS_FACTORY_ATTRIBUTE_NAME = 'handlers_factory';

class HandlersFactoryMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $factory = $this->getFactoryFromRequest($request);
        return $handler->handle(
            $request->withAttribute(
                MIDDLEWARES_ATTRIBUTE_NAME,
                $factory->createMiddlewares()
            )->withAttribute(
                HANDLER_ATTRIBUTE_NAME,
                $factory->createRequestHandler()
            )
        );
    }

    private function getFactoryFromRequest(ServerRequestInterface $request): HandlersFactory
    {
        return $request->getAttribute(HANDLERS_FACTORY_ATTRIBUTE_NAME);
    }
}