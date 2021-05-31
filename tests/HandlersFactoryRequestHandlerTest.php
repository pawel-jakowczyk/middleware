<?php

declare(strict_types=1);

namespace PJ\Middleware\Tests;

use Laminas\Diactoros\ServerRequest;
use Nyholm\Psr7\Response;
use PJ\Middleware\AttributeNames;
use PJ\Middleware\HandlersFactory;
use PJ\Middleware\HandlersFactoryRequestHandler;
use PJ\Middleware\MiddlewareCollection;
use PJ\Middleware\MiddlewareCollectionInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class HandlersFactoryRequestHandlerTest extends HandlerBaseTestCase
{
    /**
     * @test
     */
    public function itThrowsTypeErrorOnRequestWithoutHandlersFactory(): void
    {
        $this->expectException(TypeError::class);
        (new HandlersFactoryRequestHandler())->handle(new ServerRequest());
    }

    /**
     * @test
     */
    public function itProcessesThroughAllMiddlewaresFromRequest()
    {
        $response = (new HandlersFactoryRequestHandler())->handle(
            (new ServerRequest())->withAttribute(
                AttributeNames::HANDLERS_FACTORY,
                new class (
                    new MiddlewareCollection(
                        $this->createMiddleware('outside-middleware'),
                        $this->createMiddleware('inside-middleware')
                    ),
                    $this->createRequestHandler(new Response())
                ) implements HandlersFactory {
                    private MiddlewareCollectionInterface $middlewares;
                    private RequestHandlerInterface $handler;

                    public function __construct(MiddlewareCollectionInterface $middlewares, RequestHandlerInterface $handler)
                    {
                        $this->middlewares = $middlewares;
                        $this->handler = $handler;
                    }

                    public function createMiddlewares(): MiddlewareCollectionInterface
                    {
                        return $this->middlewares;
                    }

                    public function createRequestHandler(): RequestHandlerInterface
                    {
                        return $this->handler;
                    }
                }
            )
        );
        self::assertEquals('inside-middleware outside-middleware ', (string) $response->getBody());
    }
}