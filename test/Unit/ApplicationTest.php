<?php declare(strict_types=1);

namespace Scaffold\Test\Unit;

use Psr\Http\Message\ResponseInterface;

use League\Container\Container;
use PHPUnit\Framework\TestCase;
use Scaffold\Application;

use Scaffold\Test\Unit\Response\NaiveEmitter;

class ApplicationTest extends TestCase
{
    protected $app;

    public function setup()
    {
        $container = new Container;
        $container->add(
            Application::INTERFACE_RESPONSE_EMITTER,
            NaiveEmitter::class
        );
        $fixtures = '/scaffold/test/fixtures';
        $this->app = new Application([
            'config' => ['directory' => $fixtures . '/config'],
            'container' => $container,
            'views' => ['directory' => $fixtures . '/views'],
        ]);
    }

    /**
     * @expectedException        LogicException
     * @expectedExceptionMessage template name cannot be empty
     */
    public function testRenderWithMissingTemplateName()
    {
        $this->app->render('');
    }
     
    public function testMapRoute()
    {
        $app = $this->app->mapRoute('GET', '/', function () {
        });
        $this->assertEquals($this->app, $app);
    }
     
    public function testMapRoutes()
    {
        $app = $this->app->mapRoutes([
            ['GET', '/', function () {
            }],
        ]);
        $this->assertEquals($this->app, $app);
    }
     
    /**
     * @expectedException        League\Route\Http\Exception\NotFoundException
     * @expectedWxceptionMessage Not Found
     */
    public function testRunNoRoutes()
    {
        $this->app->run();
    }

    public function testRunWithRoute()
    {
        $this->app->mapRoute('GET', '/', function ($req, $res) {
            return $res;
        });
        $this->assertNotNull($this->app->run());
    }
}
