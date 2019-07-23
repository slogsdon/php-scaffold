<?php

namespace Scaffold\Router;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface RouterInterface
{
    public function __construct(ContainerInterface $container);

    public function dispatch(ServerRequestInterface $request, ResponseInterface $response);

    public function map($method, $path, $handler);
}
