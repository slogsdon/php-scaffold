<?php declare(strict_types=1);

namespace Scaffold\Test\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use Scaffold\Configuration\Configuration;

/** @psalm-suppress PropertyNotSetInConstructor */
class ConfigurationTest extends TestCase
{
    use \Scaffold\Utility\SafeGettable;

    /** @var Configuration|null */
    protected $config = null;
    /** @var (string|mixed[])[] */
    protected $options = [];

    public function setup(): void
    {
        $this->config = new Configuration;
        $this->options = [
            'foo' => 'bar',
            'views' => ['directory' => '/root'],
        ];
    }

    public function testSetOptionsSetter(): void
    {
        if ($this->config === null) {
            $this->assertTrue(false, 'Configuration not set');
            return;
        }

        $this->config->setOptions($this->options);
        $this->assertEquals($this->options, $this->config->getOptions());
    }

    public function testSetOptionsConstructor(): void
    {
        if ($this->config === null) {
            $this->assertTrue(false, 'Configuration not set');
            return;
        }

        $this->config = new Configuration($this->options);
        $this->assertEquals($this->options, $this->config->getOptions());
    }

    public function testGetViewRoot(): void
    {
        if ($this->config === null) {
            $this->assertTrue(false, 'Configuration not set');
            return;
        }

        /** @var mixed[] */
        $viewOptions = $this->safeGet($this->options, 'views', []);
        /** @var string */
        $viewDirectory = $this->safeGet($viewOptions, 'directory', '');
        $expected = getcwd() . '/..' . $viewDirectory;
        $this->config->setOptions($this->options);
        $this->assertEquals($expected, $this->config->getViewRoot());
    }
}
