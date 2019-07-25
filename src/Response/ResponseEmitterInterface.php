<?php declare(strict_types=1);

namespace Scaffold\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Standard interface for a response emitter
 */
interface ResponseEmitterInterface
{
    /**
     * Converts the `$response` to something usable
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    public function emit(ResponseInterface $response);
}
