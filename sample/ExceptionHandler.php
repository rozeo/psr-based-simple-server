<?php


namespace Sample;


use HttpServer\Http\ExceptionHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(ServerRequestInterface $request, \Throwable $throwable): ResponseInterface
    {
        echo "Boop!";
        die;
    }
}