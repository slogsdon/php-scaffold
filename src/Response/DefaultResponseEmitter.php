<?php declare(strict_types=1);

namespace Scaffold\Response;

use Zend\Diactoros\Response\SapiEmitter;

/**
 * Default response emitter for Scaffold using the Zend Diactoros `SapiEmitter`
 */
class DefaultResponseEmitter extends SapiEmitter implements ResponseEmitterInterface
{
}
