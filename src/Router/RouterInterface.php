<?php declare(strict_types=1);

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
