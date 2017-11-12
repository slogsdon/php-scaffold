<?php

namespace Scaffold\Test\Unit;

use PHPUnit\Framework\TestCase;
use Scaffold\Application;
use Scaffold\DefaultContainer;

class DefaultContainerTest extends TestCase
{
    protected $options;
    
    public function setup()
    {
        $this->options = [
            'request' => ['globals' => []],
            'views' => ['directory' => null],
        ];
    }
    
    public function testHas()
    {
        $container = new DefaultContainer($this->options);
        
        $this->assertTrue($container->has(Application::INTERFACE_CONFIGURATION));
        $this->assertTrue($container->has(Application::INTERFACE_CONTAINER));
        $this->assertTrue($container->has(Application::INTERFACE_REQUEST));
        $this->assertTrue($container->has(Application::INTERFACE_RESPONSE));
        $this->assertTrue($container->has(Application::INTERFACE_RESPONSE_EMITTER));
        $this->assertTrue($container->has(Application::INTERFACE_ROUTER));
        $this->assertTrue($container->has(Application::INTERFACE_TEMPLATE_ENGINE));
    }

    public function testGet()
    {
        $container = new DefaultContainer($this->options);

        $this->assertNotNull($container->get(Application::INTERFACE_CONFIGURATION));
        $this->assertNotNull($container->get(Application::INTERFACE_CONTAINER));
        $this->assertNotNull($container->get(Application::INTERFACE_REQUEST));
        $this->assertNotNull($container->get(Application::INTERFACE_RESPONSE));
        $this->assertNotNull($container->get(Application::INTERFACE_RESPONSE_EMITTER));
        $this->assertNotNull($container->get(Application::INTERFACE_ROUTER));
        $this->assertNotNull($container->get(Application::INTERFACE_TEMPLATE_ENGINE));
    }
}
