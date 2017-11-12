<?php

namespace Scaffold;

abstract class AbstractController
{
    protected $app;
    
    public function setApplication(ApplicationInterface $app)
    {
        $this->app = $app;
        return $this;
    }
}
