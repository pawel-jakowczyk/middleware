<?php

declare(strict_types=1);

namespace PJ\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareHandler implements RequestHandlerInterface
{
    private MiddlewareInterface $middleware;
    private RequestHandlerInterface $requestHandler;

    public function __construct(
        MiddlewareInterface $middleware,
        RequestHandlerInterface $requestHandler
    ) {
        $this->middleware = $middleware;
        $this->requestHandler = $requestHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->requestHandler);
    }
}