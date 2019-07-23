<?php declare(strict_types=1);

namespace Scaffold\Test\Unit\Response;

use Psr\Http\Message\ResponseInterface;
use Scaffold\Response\ResponseEmitterInterface;

class NaiveEmitter implements ResponseEmitterInterface
{
    public function emit(ResponseInterface $res)
    {
        return $res->getBody();
    }
}
