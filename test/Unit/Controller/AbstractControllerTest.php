<?php declare(strict_types=1);

namespace Scaffold\Test\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Scaffold\Controller\AbstractController;

use Scaffold\Test\Unit\TestApp;

/** @psalm-suppress PropertyNotSetInConstructor */
class AbstractControllerTest extends TestCase
{
    public function testSetApplication(): void
    {
        $app = new TestApp;
        $controller = new TestController;
        $this->assertNotNull($controller->setApplication($app));
    }
}
