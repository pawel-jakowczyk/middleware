# PJ Middleware Request Handler

[![Tests](https://github.com/pawel-jakowczyk/middleware/actions/workflows/php.yml/badge.svg)](https://github.com/pawel-jakowczyk/middleware/actions/workflows/php.yml)

This repository holds the MiddlewareFactoryRequestHandler which implements the Psr\Http\Server\RequestHandlerInterface.
The request handler is responsible for processing the collection of middlewares and final request handler.

To define middleware collection and request handler one needs to create MiddlewareFactory and HandlerFactory implementations. 
Those factories should be than passed to request under AttributeNames::MIDDLEWARE_FACTORY and AttributeNames::HANDLER_FACTORY.
The MiddlewareRoute can be used in order to pass factories as route defaults.

The reason why factories are used is not to create objects with their dependencies too early when they might not be used,
by using factories they are created during MiddlewareFactoryRequestHandler execution.

## Instalation

    composer require pawel-jakowczyk/middleware

## Usage

```php

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use PJ\Middleware\AttributeNames;
use PJ\Middleware\HandlerFactory;
use PJ\Middleware\MiddlewareFactoryRequestHandler;
use PJ\Middleware\EmptyMiddlewareFactory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

(new MiddlewareFactoryRequestHandler())->handle(
    (new ServerRequest())
        ->withAttribute(
            AttributeNames::MIDDLEWARE_FACTORY,
            new EmptyMiddlewareFactory()
        )
        ->withAttribute(
            AttributeNames::HANDLER_FACTORY,
            new class () implements HandlerFactory {
                public function createRequestHandler(): RequestHandlerInterface
                {
                    return new class() implements RequestHandlerInterface
                    {
                        public function handle(ServerRequestInterface $request): ResponseInterface
                        {
                            return new Response();
                        }
                    };
                }
            }
        )
);
```
