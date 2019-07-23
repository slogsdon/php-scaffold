<?php declare(strict_types=1);

namespace Scaffold;

use Interop\Container\ContainerInterface;

use League\Container\Container;
use League\Container\ReflectionContainer;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

use Scaffold\Application;
use Scaffold\Configuration\Configuration;
use Scaffold\Response\DefaultResponseEmitter;
use Scaffold\Router\DefaultRouter;
use Scaffold\Template\DefaultTemplateEngine;

class DefaultContainer extends Container implements ContainerInterface
{
    public function __construct(array $options = [])
    {
        parent::__construct();
        
        $this->share(Application::INTERFACE_CONFIGURATION, new Configuration($options));
        
        $this->share(Application::INTERFACE_REQUEST, function () use ($options) {
            return call_user_func_array(
                [ServerRequestFactory::class, 'fromGlobals'],
                $options['request']['globals']
            );
        });
        $this->share(Application::INTERFACE_CONTAINER, $this);
        $this->share(Application::INTERFACE_RESPONSE, Response::class);
        $this->share(Application::INTERFACE_RESPONSE_EMITTER, DefaultResponseEmitter::class);
        $this->share(Application::INTERFACE_ROUTER, DefaultRouter::class);
        $this->share(
            Application::INTERFACE_TEMPLATE_ENGINE,
            new DefaultTemplateEngine($this->get(Application::INTERFACE_CONFIGURATION))
        );
    }
}
