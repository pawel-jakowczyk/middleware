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
use PJ\Middleware\AttributeNames;
use PJ\Middleware\MiddlewareRequestHandler;
use PJ\Middleware\MiddlewareCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

(new MiddlewareRequestHandler())->handle(
    (new ServerRequest())
        ->withAttribute(
            AttributeNames::MIDDLEWARES,
            new MiddlewareCollection()
        )
        ->withAttribute(
            AttributeNames::HANDLER,
            new class () implements RequestHandlerInterface {
                public function handle(ServerRequestInterface $request) : ResponseInterface{
                    return new Response();
                }
            }
        )
);
```
