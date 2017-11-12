<?php

namespace Scaffold\Test\Unit;

class TestObj
{
    public $foo = null;
    public function setFoo($value)
    {
        $this->foo = $value;
        return $this;
    }
}
