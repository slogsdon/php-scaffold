<?php declare(strict_types=1);

namespace Scaffold\Test\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Scaffold\Controller\ChildControllerFactory;

/** @psalm-suppress PropertyNotSetInConstructor */
class ChildControllerFactoryTest extends TestCase
{
    public function testMaybeMake(): void
    {
        $this->assertEquals('foo', ChildControllerFactory::maybeMake('foo'));
        $this->assertEquals(['foo'], ChildControllerFactory::maybeMake(['foo']));
        $this->assertEquals(['foo', 'bar'], ChildControllerFactory::maybeMake(['foo', 'bar']));
    }

    public function testSetDeps(): void
    {
        $obj = new TestObj;

        $this->assertNotNull(ChildControllerFactory::setDeps($obj, ['foo' => 'bar']));
        $this->assertNotNull($obj->foo);
    }
}
