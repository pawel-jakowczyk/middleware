<?php

declare(strict_types=1);

namespace PJ\Middleware\Tests;

use Laminas\Diactoros\ServerRequest;
use Nyholm\Psr7\Response;
use PJ\Middleware\AttributeNames;
use PJ\Middleware\HandlerFactory;
use PJ\Middleware\MiddlewareFactoryRequestHandler;
use PJ\Middleware\MiddlewareCollection;
use PJ\Middleware\MiddlewareCollectionInterface;
use PJ\Middleware\MiddlewareFactory;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class MiddlewareFactoryRequestHandlerTest extends HandlerBaseTestCase
{
    /**
     * @test
     */
    public function itThrowsTypeErrorOnRequestWithoutHandlersFactory(): void
    {
        $this->expectException(TypeError::class);
        (new MiddlewareFactoryRequestHandler())->handle(new ServerRequest());
    }

    /**
     * @test
     */
    public function itProcessesThroughAllMiddlewaresFromRequest()
    {
        $response = (new MiddlewareFactoryRequestHandler())->handle(
            (new ServerRequest())->withAttribute(
                AttributeNames::HANDLER_FACTORY,
                new class (
                    $this->createRequestHandler(new Response())
                ) implements HandlerFactory {
                    private RequestHandlerInterface $handler;

                    public function __construct(RequestHandlerInterface $handler)
                    {
                        $this->handler = $handler;
                    }

                    public function createRequestHandler(): RequestHandlerInterface
                    {
                        return $this->handler;
                    }
                }
            )->withAttribute(
                AttributeNames::MIDDLEWARE_FACTORY,
                new class (
                    new MiddlewareCollection(
                        $this->createMiddleware('outside-middleware'),
                        $this->createMiddleware('inside-middleware')
                    )
                ) implements MiddlewareFactory {
                    private MiddlewareCollectionInterface $middlewareCollection;

                    public function __construct(MiddlewareCollectionInterface $middlewareCollection)
                    {
                        $this->middlewareCollection = $middlewareCollection;
                    }

                    public function createMiddlewares(): MiddlewareCollectionInterface
                    {
                        return $this->middlewareCollection;
                    }
                }
            )
        );
        self::assertEquals('inside-middleware outside-middleware ', (string) $response->getBody());
    }
}