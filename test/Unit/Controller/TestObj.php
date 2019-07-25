<?php declare(strict_types=1);

namespace Scaffold\Test\Unit\Controller;

class TestObj extends \Scaffold\Controller\AbstractController
{
    public $foo = null;
    public function setFoo($value)
    {
        $this->foo = $value;
        return $this;
    }
}
