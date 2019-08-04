<?php declare(strict_types=1);

namespace Scaffold\Test\Unit\Controller;

class TestObj extends \Scaffold\Controller\AbstractController
{
    /** @var mixed */
    public $foo = null;
    /**
     * @param mixed $value
     * @return self
     */
    public function setFoo($value): self
    {
        $this->foo = $value;
        return $this;
    }
}
