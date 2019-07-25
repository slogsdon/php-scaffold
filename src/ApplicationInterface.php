<?php declare(strict_types=1);

namespace Scaffold;

/**
 * Standard interface for an application
 */
interface ApplicationInterface
{
    /**
     * Helper function to render a `$template` with the given `$data`
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = []);
}
