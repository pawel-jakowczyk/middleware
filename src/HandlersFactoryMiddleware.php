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