<?php declare(strict_types=1);

namespace Scaffold\Controller;

/**
 * Aids in child controller instantiation
 */
class ChildControllerFactory
{
    /**
     * Attempts to update a callable `$handler` to instantiate an
     * `AbstractController` sub-class
     *
     * @param mixed $handler
     * @param array $deps
     * @return mixed
     */
    public static function maybeMake($handler, array $deps = [])
    {
        if (is_array($handler) && count($handler) === 2) {
            $klass = $handler[0];
            $func = $handler[1];
            $obj = is_string($klass) && is_subclass_of($klass, AbstractController::class)
                ? static::setDeps(new $klass, $deps) : $klass;
            $handler = [$obj, $func];
        }
        
        return $handler;
    }

    /**
     * Sets dependencies of an `AbstractController` sub-class
     *
     * @param AbstractController $obj
     * @param array $deps
     * @return AbstractController
     */
    public static function setDeps($obj, array $deps)
    {
        foreach ($deps as $k => $v) {
            $method = 'set' . ucfirst($k);
            if (method_exists($obj, $method)) {
                $obj->{$method}($v);
            }
        }
        
        return $obj;
    }
}
