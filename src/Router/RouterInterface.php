<?php declare(strict_types=1);

namespace Scaffold\Router;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Standard interface for a router
 */
interface RouterInterface
{


    /**
     * Handles the incoming `$request` to produce a proper `$response`
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request, ResponseInterface $response);

    /**
     * Defines a `$handler` for a given HTTP `$method` and `$path`
     * combination
     *
     * @param string $method
     * @param string $path
     * @param callable $handler
     * @return
     */
    public function map($method, $path, $handler);
}
