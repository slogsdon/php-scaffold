<?php

namespace Scaffold;

interface ApplicationInterface
{
    public function render(string $template, array $data = []);
}
