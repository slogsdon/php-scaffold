<?php declare(strict_types=1);

namespace Scaffold;

interface ApplicationInterface
{
    public function render(string $template, array $data = []);
}
