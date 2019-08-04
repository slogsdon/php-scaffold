<?php declare(strict_types=1);

namespace Scaffold;

use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Scaffold\Configuration\ConfigurationInterface;
use Scaffold\Controller\ChildControllerFactory;
use Scaffold\Response\ResponseEmitterInterface;
use Scaffold\Router\RouterInterface;
use Scaffold\Template\TemplateEngineInterface;

/**
 * Application orchestrator
 */
class Application implements ApplicationInterface
{
    use \Scaffold\Utility\SafeGettable;

    const INTERFACE_CONFIGURATION = ConfigurationInterface::class;
    const INTERFACE_CONTAINER = ContainerInterface::class;
    const INTERFACE_REQUEST = ServerRequestInterface::class;
    const INTERFACE_RESPONSE = ResponseInterface::class;
    const INTERFACE_RESPONSE_EMITTER = ResponseEmitterInterface::class;
    const INTERFACE_ROUTER = RouterInterface::class;
    const INTERFACE_TEMPLATE_ENGINE = TemplateEngineInterface::class;

    /**
     * Current router instance
     *
     * @var RouterInterface
     */
    public $route;

    /**
     * Current service container instance
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Instantiates a new object
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options = $this->setOptionsWithDefaults($options);
        $this->prepareContainer($options);
        $this->prepareRouter($options);
    }

    /**
     * Runs the application
     *
     * @return mixed
     */
    public function run()
    {
        $response = $this->getRouter()->dispatch($this->getServerRequest(), $this->getResponse());
        return $this->getResponseEmitter()->emit($response);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = []): string
    {
        return $this->getTemplateEngine()->render($template, $data);
    }

    /**
     * Sets up the service container instance
     *
     * @param array $options
     *
     * @return void
     */
    protected function prepareContainer(array $options): void
    {
        /** @var ContainerInterface */
        $this->container = $options['container'] ?? new Container;

        if (method_exists($this->container, 'delegate')) {
            $this->container->delegate(new DefaultContainer($options));
            $this->container->delegate(new ReflectionContainer);
        }
    }

    /**
     * Sets up the router instance
     *
     * @param array $options
     *
     * @return void
     */
    protected function prepareRouter(array $options): void
    {
        /** @var array */
        $configOptions = $this->safeGet($options, 'config', []);
        $routes = implode(DIRECTORY_SEPARATOR, [
            getcwd(),
            '..',
            $this->safeGet($configOptions, 'directory', ''),
            'routes.php',
        ]);

        if (file_exists($routes)) {
            /** @var array */
            $includedRoutes = include $routes;
            $this->mapRoutes($includedRoutes);
        }

        $this->route = $this->getRouter();
    }

    /**
     * Default options for Scaffold
     *
     * @return ((array[]|string)[]|null)[]
     */
    public function getDefaultOptions(): array
    {
        return [
            'config' => ['directory' => 'config'],
            'container' => null,
            'request' => [
                'globals' => [
                    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES,
                ],
            ],
            'views' => ['directory' => 'views'],
        ];
    }

    /**
     * Gets active options, applying defaults when necessary
     *
     * @param array $options
     * @return array
     */
    public function setOptionsWithDefaults(array $options)
    {
        return array_replace($this->getDefaultOptions(), $options);
    }

    /**
     * Maps a set of routes
     *
     * @param array $routes
     *
     * @return self
     */
    public function mapRoutes(array $routes): self
    {
        /** @psalm-var array<int, mixed> $route */
        foreach ($routes as $route) {
            call_user_func_array([$this, 'mapRoute'], $route);
        }
        return $this;
    }

    /**
     * Defines a `$handler` for a given HTTP `$method` and `$route`
     * combination
     *
     * @param string $method
     * @param string $route
     * @param callable $handler
     *
     * @return self
     */
    public function mapRoute(string $method, string $route, $handler): self
    {
        /** @var callable */
        $handler = ChildControllerFactory::maybeMake($handler, [
            'application' => $this,
        ]);
        $this->getRouter()->map($method, $route, $handler);
        return $this;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        /** @var RouterInterface */
        return $this->container->get(self::INTERFACE_ROUTER);
    }

    /**
     * @return ServerRequestInterface
     */
    public function getServerRequest(): ServerRequestInterface
    {
        /** @var ServerRequestInterface */
        return $this->container->get(self::INTERFACE_REQUEST);
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        /** @var ResponseInterface */
        return $this->container->get(self::INTERFACE_RESPONSE);
    }

    /**
     * @return ResponseEmitterInterface
     */
    public function getResponseEmitter(): ResponseEmitterInterface
    {
        /** @var ResponseEmitterInterface */
        return $this->container->get(self::INTERFACE_RESPONSE_EMITTER);
    }

    /**
     * @return TemplateEngineInterface
     */
    public function getTemplateEngine(): TemplateEngineInterface
    {
        /** @var TemplateEngineInterface */
        return $this->container->get(self::INTERFACE_TEMPLATE_ENGINE);
    }
}
