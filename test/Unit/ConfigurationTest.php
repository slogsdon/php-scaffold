<?php

namespace Scaffold\Test\Unit;

use PHPUnit\Framework\TestCase;
use Scaffold\Configuration;

class ConfigurationTest extends TestCase
{
    protected $config;
    protected $options;
    
    public function setup()
    {
        $this->config = new Configuration;
        $this->options = [
            'foo' => 'bar',
            'views' => ['directory' => '/root'],
        ];
    }
    
    public function testSetOptionsSetter()
    {
        $this->config->setOptions($this->options);
        $this->assertEquals($this->options, $this->config->getOptions());
    }
    
    public function testSetOptionsConstructor()
    {
        $this->config = new Configuration($this->options);
        $this->assertEquals($this->options, $this->config->getOptions());
    }
    
    public function testGetViewRoot()
    {
        $expected = getcwd() . '/..' . $this->options['views']['directory'];
        $this->config->setOptions($this->options);
        $this->assertEquals($expected, $this->config->getViewRoot());
    }
}
