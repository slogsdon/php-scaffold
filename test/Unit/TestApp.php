<?php declare(strict_types=1);

namespace Scaffold\Test\Unit;

use Scaffold\ApplicationInterface;

class TestApp implements ApplicationInterface
{
    /**
     * @return string
     */
    public function render(string $name, array $data = [])
    {
        return "";
    }
}
