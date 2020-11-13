<?php

require_once __DIR__ . '/vendor/autoload.php';

$container = new \Sample\DiContainer();

$container->bind(\HttpServer\Http\ExceptionHandlerInterface::class, \Sample\ExceptionHandler::class);
$container->bind(\Psr\Http\Message\ServerRequestFactoryInterface::class, \Sample\ServerRequestFactory::class);
$container->bind(\HttpServer\Http\RouterInterface::class, \Sample\Router::class);
$container->bind(\HttpServer\Http\MiddlewareInterface::class, \Sample\Middleware::class);

$app = new \HttpServer\Application($container);

$app->runHttp();