<?php

namespace Scaffold\Test\Unit;

use PHPUnit\Framework\TestCase;
use Scaffold\ChildControllerFactory;

class ChildControllerFactoryTest extends TestCase
{
    public function testMaybeMake()
    {
        $this->assertEquals('foo', ChildControllerFactory::maybeMake('foo'));
        $this->assertEquals(['foo'], ChildControllerFactory::maybeMake(['foo']));
        $this->assertEquals(['foo', 'bar'], ChildControllerFactory::maybeMake(['foo', 'bar']));
    }
    
    public function testSetDeps()
    {
        $obj = new TestObj;
        
        $this->assertNotNull(ChildControllerFactory::setDeps($obj, ['foo' => 'bar']));
        $this->assertNotNull(ChildControllerFactory::setDeps($obj->foo, ['foo' => 'bar']));
    }
}
