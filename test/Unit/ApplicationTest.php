<?php declare(strict_types=1);

namespace Scaffold\Test\Unit;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use League\Container\Container;
use PHPUnit\Framework\TestCase;
use Scaffold\Application;

use Scaffold\Test\Unit\Response\NaiveEmitter;

/** @psalm-suppress PropertyNotSetInConstructor */
class ApplicationTest extends TestCase
{
    /** @var Application */
    protected $app;

    public function setup(): void
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
    public function testRenderWithMissingTemplateName(): void
    {
        $this->app->render('');
    }

    public function testMapRoute(): void
    {
        $app = $this->app->mapRoute('GET', '/', function (): void {
        });
        $this->assertEquals($this->app, $app);
    }

    public function testMapRoutes(): void
    {
        $app = $this->app->mapRoutes([
            ['GET', '/', function (): void {
            }],
        ]);
        $this->assertEquals($this->app, $app);
    }

    /**
     * @expectedException        League\Route\Http\Exception\NotFoundException
     * @expectedWxceptionMessage Not Found
     */
    public function testRunNoRoutes(): void
    {
        $this->app->run();
    }

    public function testRunWithRoute(): void
    {
        $this->app->mapRoute('GET', '/', function (ServerRequestInterface $req, ResponseInterface $res) {
            return $res;
        });
        $this->assertNotNull($this->app->run());
    }
}
