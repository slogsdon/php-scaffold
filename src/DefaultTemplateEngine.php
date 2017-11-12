<?php

namespace Scaffold;

use League\Plates\Engine;

class DefaultTemplateEngine extends Engine implements TemplateEngineInterface
{
    public function __construct(ConfigurationInterface $config)
    {
        parent::__construct($config->getViewRoot());
    }
}
