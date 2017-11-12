<?php

namespace Scaffold;

interface TemplateEngineInterface
{
    public function render($name, array $data = array());
}
