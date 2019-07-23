<?php

namespace Scaffold\Template;

interface TemplateEngineInterface
{
    public function render($name, array $data = array());
}
