<?php declare(strict_types=1);

namespace Scaffold\Configuration;

/**
 * Standard interface for a configuration
 */
interface ConfigurationInterface
{
    /**
     * Dependency injection setter for configuration options
     *
     * @param array $options
     * @return ConfigurationInterface
     */
    public function setOptions(array $options);

    /**
     * Root directory for views
     *
     * @return string
     */
    public function getViewRoot();
}
