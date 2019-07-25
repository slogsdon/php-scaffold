<?php declare(strict_types=1);

namespace Scaffold\Utility;

/**
 * Allows for safe access to collections
 */
trait SafeGettable
{
    /**
     * Safely gets a value from `$collection` at `$index`, falling
     * back to `$default` when `$index` isn't set
     *
     * @param mixed $collection
     * @param integer|string $index
     * @param mixed $default
     * @return mixed
     */
    private function safeGet($collection, $index, $default = null)
    {
        if (is_array($collection) && isset($collection[$index])) {
            return $collection[$index];
        }
        
        return $default;
    }
}
