<?php

namespace SmtpSdk;

use Assert\Assertion as BaseAssertion;
use phpDocumentor\Reflection\Types\Void_;
use SmtpSdk\Exception\InvalidArgumentException;

class Assertion extends BaseAssertion
{
    protected static $exceptionClass = InvalidArgumentException::class;

    public static function keysInArray(array $array, array $validKeys)
    {
        foreach (array_keys($array) as $key) {
            static::inArray($key, $validKeys, 'Unknown paramater [%s].');
        }
    }

    public static function parameterExists(array $array, string $key): bool
    {
        return static::keyIsset($array, $key, 'Parameter [%s] is not specified.');
    }
}
