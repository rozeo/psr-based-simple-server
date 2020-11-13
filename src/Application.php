<?php


namespace HttpServer;


use HttpServer\Http\Kernel as HttpKernel;
use Psr\Container\ContainerInterface;

class Application
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function runHttp(): void
    {
        /** @var HttpKernel $kernel */
        $kernel = $this->container->get(HttpKernel::class);

        $kernel->run();
    }

    public function runConsole(): void
    {
        // $this->container->get();
    }
}