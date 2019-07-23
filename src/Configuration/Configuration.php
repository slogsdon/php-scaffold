<?php declare(strict_types=1);

namespace Scaffold\Configuration;

class Configuration implements ConfigurationInterface
{
    protected $options;
    
    public function __construct(array $options = null)
    {
        $this->options = $options;
    }
    
    public function getOptions()
    {
        return $this->options;
    }
    
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
    
    public function getViewRoot()
    {
        return implode(DIRECTORY_SEPARATOR, [
            getcwd(),
            '..',
            trim($this->options['views']['directory'] ?? '', DIRECTORY_SEPARATOR),
        ]);
    }
}
