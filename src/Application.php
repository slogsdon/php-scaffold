<?php declare(strict_types=1);

namespace Scaffold;

use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
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
    const INTERFACE_REQUEST = RequestInterface::class;
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
        $response = $this->container->get(static::INTERFACE_ROUTER)->dispatch(
            $this->container->get(static::INTERFACE_REQUEST),
            $this->container->get(static::INTERFACE_RESPONSE)
        );
        return $this->container->get(static::INTERFACE_RESPONSE_EMITTER)->emit($response);
    }
    
    /**
     * {@inheritDoc}
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = [])
    {
        return $this->container->get(static::INTERFACE_TEMPLATE_ENGINE)->render($template, $data);
    }
    
    /**
     * Sets up the service container instance
     *
     * @param array $options
     */
    protected function prepareContainer(array $options)
    {
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
     */
    protected function prepareRouter(array $options)
    {
        $configOptions = $this->safeGet($options, 'config', []);
        $routes = implode(DIRECTORY_SEPARATOR, [
            getcwd(),
            '..',
            $this->safeGet($configOptions, 'directory', ''),
            'routes.php',
        ]);
        
        if (file_exists($routes)) {
            $this->mapRoutes(include $routes);
        }
        
        $this->route = $this->container->get(static::INTERFACE_ROUTER);
    }
    
    /**
     * Default options for Scaffold
     *
     * @return array
     */
    public function getDefaultOptions()
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
     * @return ApplicationInterface
     */
    public function mapRoutes(array $routes)
    {
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
     * @return ApplicationInterface
     */
    public function mapRoute(string $method, string $route, $handler)
    {
        $this->container->get(static::INTERFACE_ROUTER)->map(
            $method,
            $route,
            ChildControllerFactory::maybeMake($handler, [
                'application' => $this,
            ])
        );
        return $this;
    }
}
