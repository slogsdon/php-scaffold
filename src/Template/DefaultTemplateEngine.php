<?php declare(strict_types=1);

namespace Scaffold\Template;

use League\Plates\Engine;

use Scaffold\Configuration\ConfigurationInterface;

/**
 * Default template engine for Scaffold using The PHP League's Plates project
 */
class DefaultTemplateEngine extends Engine implements TemplateEngineInterface
{
    /**
     * Instantiates a new object
     *
     * @param ConfigurationInterface $config
     */
    public function __construct(ConfigurationInterface $config)
    {
        parent::__construct($config->getViewRoot());
    }
}
