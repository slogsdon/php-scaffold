<?php

namespace Scaffold;

interface ConfigurationInterface
{
    public function setOptions(array $options);
    
    public function getViewRoot();
}
