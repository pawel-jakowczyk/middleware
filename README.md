# PJ Middleware Request Handler

This repository holds the MiddlewareRequestHandler which implements the Psr\Http\Server\RequestHandlerInterface.
The request handler is responsible for processing the collection of middlewares and final request handler.
The middlewares collection and request handler need to be set in server request attributes.

## Instalation

    composer require pawel-jakowczyk/middleware

## Usage

```php

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use PJ\Middleware\MiddlewareRequestHandler;
use PJ\Middleware\MiddlewareCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use const PJ\Middleware\MIDDLEWARES_ATTRIBUTE_NAME;
use const PJ\Middleware\HANDLER_ATTRIBUTE_NAME;

(new MiddlewareRequestHandler())->handle(
    (new ServerRequest())
        ->withAttribute(
            MIDDLEWARES_ATTRIBUTE_NAME,
            new MiddlewareCollection()
        )
        ->withAttribute(
            HANDLER_ATTRIBUTE_NAME,
            new class () implements RequestHandlerInterface {
                public function handle(ServerRequestInterface $request) : ResponseInterface{
                    return new Response();
                }
            }
        )
);
```
