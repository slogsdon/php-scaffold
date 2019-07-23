<?php declare(strict_types=1);

namespace Scaffold\Template;

use League\Plates\Engine;

use Scaffold\Configuration\ConfigurationInterface;

class DefaultTemplateEngine extends Engine implements TemplateEngineInterface
{
    public function __construct(ConfigurationInterface $config)
    {
        parent::__construct($config->getViewRoot());
    }
}
