<?php declare(strict_types=1);

namespace Scaffold\Controller;

use Scaffold\ApplicationInterface;

abstract class AbstractController
{
    protected $app;
    
    public function setApplication(ApplicationInterface $app)
    {
        $this->app = $app;
        return $this;
    }
}
