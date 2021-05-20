<?php

namespace pj\middleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UnexpectedValueException;

class MiddlewareHandler implements RequestHandlerInterface
{
    private RequestHandlerInterface $finalRequestHandler;

    public function __construct(RequestHandlerInterface $finalRequestHandler)
    {
        $this->finalRequestHandler = $finalRequestHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middlewares = $request->getAttribute('middlewares');
        if (!$middewares instanceof MiddlewareCollection) {
            throw new UnexpectedValueException(
                'MiddlewareCollection type expected in middleware attribute'
            );
        }
        $middleware = current($middlewares);
        $request->withAttribute(
            'middlewares',
            $middlewares->withoutCurrent()
        );
        return $middleware ?
            $middleware->process($request, $this) :
            $this->finalRequestHandler->handle($request);
    }
}