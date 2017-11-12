<?php

namespace Scaffold\Test\Unit;

use PHPUnit\Framework\TestCase;
use Scaffold\AbstractController;
use Scaffold\ApplicationInterface;

class AbstractControllerTest extends TestCase
{
    public function testSetApplication()
    {
        $app = new TestApp;
        $controller = new TestController;
        $this->assertNotNull($controller->setApplication($app));
    }
}
