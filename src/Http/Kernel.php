<?php

namespace HttpServer\Http;

use HttpServer\Http\Exceptions\HandlerNotFoundException;
use HttpServer\Http\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class Kernel
{

    private ServerRequestFactoryInterface $factory;

    private RouterInterface $router;

    private MiddlewareInterface $middleware;

    private ExceptionHandlerInterface $handler;

    public function __construct(
        ServerRequestFactoryInterface $factory,
        RouterInterface $router,
        MiddlewareInterface $middleware,
        ExceptionHandlerInterface $handler
    ) {
        $this->factory = $factory;
        $this->router = $router;
        $this->middleware = $middleware;
        $this->handler = $handler;
    }

    public function run(): void
    {
        $request = $this->factory->createServerRequest(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_SERVER
        );

        try {
             if (!$handler = $this->router->getHandler($request)) {
                 throw new HandlerNotFoundException;
             }

             $this->startOutputBuffer(true);
             $response = $this->middleware->process($request, $handler);
             $this->releaseOutputBuffer();

             $this->terminate($response);
        } catch(\Throwable $e) {
            $this->terminate($this->handler->handle($request, $e));
        }
    }

    private function terminate(ResponseInterface $response): void
    {
        $this->releaseOutputBuffer();
        $this->startOutputBuffer();
        $this->releaseOutputBuffer();

        exit(0);
    }

    protected function startOutputBuffer(bool $disableOutput = false)
    {
        $disableOutput ? ob_start(fn () => '') : ob_start();
    }

    protected function releaseOutputBuffer()
    {
        ob_end_flush();
    }
}