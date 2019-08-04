<?php declare(strict_types=1);

namespace Scaffold\Configuration;

/**
 * Default configuration for Scaffold
 */
class Configuration implements ConfigurationInterface
{
    use \Scaffold\Utility\SafeGettable;

    /**
     * Current options
     *
     * @var array|null
     */
    protected $options;

    /**
     * Instantiates a new object
     *
     * @param array|null $options
     */
    public function __construct(array $options = null)
    {
        $this->options = $options;
    }

    /**
     * Gets the current configuration options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options ?? [];
    }

    /**
     * {@inheritDoc}
     *
     * @param array $options
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getViewRoot()
    {
        /** @var mixed[] */
        $viewOptions = $this->safeGet($this->options, 'views', []);
        /** @var string */
        $viewDirectory = $this->safeGet($viewOptions, 'directory', '');
        return implode(DIRECTORY_SEPARATOR, [
            getcwd(),
            '..',
            trim($viewDirectory, DIRECTORY_SEPARATOR),
        ]);
    }
}
