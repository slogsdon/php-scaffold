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

class Application implements ApplicationInterface
{
    const INTERFACE_CONFIGURATION = ConfigurationInterface::class;
    const INTERFACE_CONTAINER = ContainerInterface::class;
    const INTERFACE_REQUEST = RequestInterface::class;
    const INTERFACE_RESPONSE = ResponseInterface::class;
    const INTERFACE_RESPONSE_EMITTER = ResponseEmitterInterface::class;
    const INTERFACE_ROUTER = RouterInterface::class;
    const INTERFACE_TEMPLATE_ENGINE = TemplateEngineInterface::class;
    
    public $route;
    
    protected $container;
    
    public function __construct(array $options = [])
    {
        $options = $this->setOptionsDefaults($options);
        $this->prepareContainer($options);
        $this->prepareRouter($options);
    }
    
    public function run()
    {
        $response = $this->container->get(static::INTERFACE_ROUTER)->dispatch(
            $this->container->get(static::INTERFACE_REQUEST),
            $this->container->get(static::INTERFACE_RESPONSE)
        );
        return $this->container->get(static::INTERFACE_RESPONSE_EMITTER)->emit($response);
    }
    
    public function render(string $template, array $data = [])
    {
        return $this->container->get(static::INTERFACE_TEMPLATE_ENGINE)->render($template, $data);
    }
    
    protected function prepareContainer(array $options)
    {
        $this->container = $options['container'] ?? new Container;
        
        if (method_exists($this->container, 'delegate')) {
            $this->container->delegate(new DefaultContainer($options));
            $this->container->delegate(new ReflectionContainer);
        }
    }
    
    protected function prepareRouter(array $options)
    {
        $routes = implode(DIRECTORY_SEPARATOR, [
            getcwd(),
            '..',
            $options['config']['directory'],
            'routes.php',
        ]);
        
        if (file_exists($routes)) {
            $this->mapRoutes(include $routes);
        }
        
        $this->route = $this->container->get(static::INTERFACE_ROUTER);
    }
    
    public function getDefaultOptions()
    {
        return [
            'config' => ['directory' => 'config'],
            'container' => null,
            'request' => ['globals' => [
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES,
            ]],
            'views' => ['directory' => 'views'],
        ];
    }
    
    public function setOptionsDefaults(array $options)
    {
        return array_replace($this->getDefaultOptions(), $options);
    }
    
    public function mapRoutes(array $routes)
    {
        foreach ($routes as $route) {
            call_user_func_array([$this, 'mapRoute'], $route);
        }
        return $this;
    }

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
