<?php declare(strict_types=1);

namespace Scaffold\Configuration;

interface ConfigurationInterface
{
    public function setOptions(array $options);
    
    public function getViewRoot();
}
