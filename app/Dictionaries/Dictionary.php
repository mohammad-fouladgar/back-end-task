<?php

namespace App\Dictionaries;

use ReflectionClass;
use ReflectionException;

abstract class Dictionary
{
    /**
     * @throws ReflectionException
     */
    final public static function toArray(): array
    {
        return (new ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * @throws ReflectionException
     */
    final public static function isValid(string $value): bool
    {
        return in_array($value, self::toArray(), true);
    }
}
