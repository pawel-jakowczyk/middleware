<?php

declare(strict_types=1);

namespace PJ\Middleware\Tests;


use Nyholm\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HandlerBaseTestCase extends TestCase
{
    protected function createMiddleware(string $name): MiddlewareInterface
    {
        return new class ($name) implements MiddlewareInterface
        {
            private string $name;

            public function __construct(string $name)
            {
                $this->name = $name;
            }

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                $response = $handler->handle($request);
                $response = $response->withBody(Stream::create($response->getBody() . $this->name . ' '));
                return $response;
            }
        };
    }

    protected function createRequestHandler(ResponseInterface $expectedResponse): RequestHandlerInterface
    {
        $requestHandler = $this->createMock(RequestHandlerInterface::class);
        $requestHandler->expects(self::once())
            ->method('handle')
            ->willReturn($expectedResponse);
        return $requestHandler;
    }
}