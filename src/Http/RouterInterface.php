<?php


namespace HttpServer\Http;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface RouterInterface
{
    public function getHandler(ServerRequestInterface $request): ?RequestHandlerInterface;
}