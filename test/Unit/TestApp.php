<?php declare(strict_types=1);

namespace Scaffold\Test\Unit;

use Scaffold\ApplicationInterface;

class TestApp implements ApplicationInterface
{
    public function render(string $name, array $data = [])
    {
    }
}
