<?php

namespace Scaffold\Test\Unit;

use Psr\Http\Message\ResponseInterface;
use Scaffold\ResponseEmitterInterface;

class NaiveEmitter implements ResponseEmitterInterface
{
    public function emit(ResponseInterface $res)
    {
        return $res->getBody();
    }
}
