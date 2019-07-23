<?php

namespace Scaffold\Configuration;

interface ConfigurationInterface
{
    public function setOptions(array $options);
    
    public function getViewRoot();
}
