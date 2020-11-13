<?php


namespace Sample;


use HttpServer\Http\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Router implements RouterInterface
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getHandler(ServerRequestInterface $request): ?RequestHandlerInterface
    {
        return $this->container->get(SampleHandler::class);
    }
}