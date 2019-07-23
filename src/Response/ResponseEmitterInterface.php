<?php

namespace Scaffold\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseEmitterInterface
{
    public function emit(ResponseInterface $response);
}
