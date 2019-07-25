<?php declare(strict_types=1);

namespace Scaffold\Controller;

use Scaffold\ApplicationInterface;

/**
 * Base class for controllers
 */
abstract class AbstractController
{
    /**
     * Current application instance
     *
     * @var ApplicationInterface
     */
    protected $app;
    
    /**
     * Dependency injection setter for an `ApplicationInterface`
     * instance
     *
     * @param ApplicationInterface $app
     * @return AbstractController
     */
    public function setApplication(ApplicationInterface $app)
    {
        $this->app = $app;
        return $this;
    }
}
