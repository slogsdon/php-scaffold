<?php declare(strict_types=1);

namespace Scaffold\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseEmitterInterface
{
    public function emit(ResponseInterface $response);
}
