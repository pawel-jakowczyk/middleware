<?php

declare(strict_types=1);

namespace PJ\Middleware\Tests;

use Laminas\Diactoros\ServerRequest;
use Nyholm\Psr7\Response;
use PJ\Middleware\AttributeNames;
use PJ\Middleware\MiddlewareCollection;
use PJ\Middleware\MiddlewareCollectionInterface;
use PJ\Middleware\MiddlewareRequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class MiddlewareRequestHandlerTest extends HandlerBaseTestCase
{
    /**
     * @test
     */
    public function itThrowsTypeErrorWhenNoMiddlewareAttributeIsSet()
    {
        $this->expectException(TypeError::class);
        $this->handleRequest(new ServerRequest());
    }

    /**
     * @test
     */
    public function itThrowsTypeErrorWhenNoHandlerAttributeIsSet()
    {
        $this->expectException(TypeError::class);
        $request = (new ServerRequest())
            ->withAttribute(
                AttributeNames::MIDDLEWARES,
                new MiddlewareCollection()
            );
        $this->handleRequest($request);
    }

    /**
     * @test
     */
    public function itReturnsHandlerResponseWhenThereAreNoMiddlewares()
    {
        $response = (new MiddlewareRequestHandler())->handle(
            $this->createRequest(
                new MiddlewareCollection(),
                $expectedResponse = new Response()
            )
        );
        self::assertSame($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function itProcessesThroughAllMiddlewaresFromRequest()
    {
        $response = (new MiddlewareRequestHandler())->handle(
            $this->createRequest(
                new MiddlewareCollection(
                    $this->createMiddleware('outside-middleware'),
                    $this->createMiddleware('inside-middleware')
                ),
                new Response()
            )
        );
        self::assertEquals('inside-middleware outside-middleware ', (string) $response->getBody());
    }

    private function handleRequest(ServerRequestInterface $request): void
    {
        (new MiddlewareRequestHandler())->handle($request);
    }

    private function createRequest(
        MiddlewareCollectionInterface $middlewareCollection,
        ResponseInterface $expectedResponse
    ): ServerRequest {
        $requestHandler = $this->createMock(RequestHandlerInterface::class);
        $requestHandler->expects(self::once())
            ->method('handle')
            ->willReturn($expectedResponse);

        return (new ServerRequest())
            ->withAttribute(
                AttributeNames::MIDDLEWARES,
                $middlewareCollection
            )->withAttribute(
                AttributeNames::HANDLER,
                $requestHandler
            );
    }
}