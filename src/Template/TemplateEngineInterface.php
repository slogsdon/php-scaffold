<?php declare(strict_types=1);

namespace Scaffold\Template;

interface TemplateEngineInterface
{
    public function render($name, array $data = array());
}
