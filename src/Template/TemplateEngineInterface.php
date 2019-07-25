<?php declare(strict_types=1);

namespace Scaffold\Template;

/**
 * Standard interface for a templating engine
 */
interface TemplateEngineInterface
{
    /**
     * Renders a template with `$name` using the given `$data`
     *
     * @param string $name
     * @param array $data
     * @return string
     */
    public function render($name, array $data = array());
}
