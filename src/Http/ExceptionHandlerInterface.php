<?php


namespace HttpServer\Http;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ExceptionHandlerInterface
{
    public function handle(ServerRequestInterface $handler, \Throwable $throwable): ResponseInterface;
}