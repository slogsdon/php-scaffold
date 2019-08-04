<?php declare(strict_types=1);

namespace Scaffold\Test\Unit;

use PHPUnit\Framework\TestCase;
use Scaffold\Application;
use Scaffold\DefaultContainer;

/** @psalm-suppress PropertyNotSetInConstructor */
class DefaultContainerTest extends TestCase
{
    /** @var mixed[] */
    protected $options = [];

    public function setup(): void
    {
        $this->options = [
            'request' => ['globals' => []],
            'views' => ['directory' => null],
        ];
    }

    public function testHas(): void
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

    public function testGet(): void
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
