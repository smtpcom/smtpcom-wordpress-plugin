<?php

namespace SmtpSdk;

use Assert\Assertion as BaseAssertion;
use SmtpSdk\Exception\InvalidArgumentException;

class Assertion extends BaseAssertion
{
    protected static $exceptionClass = InvalidArgumentException::class;

    public static function keysInArray($array, $validKeys)
    {
        foreach (array_keys($array) as $key) {
            static::inArray($key, $validKeys, 'Unknown paramater [%s].');
        }
    }

    public static function parameterExists($array, $key)
    {
        return static::keyIsset($array, $key, 'Parameter [%s] is not specified.');
    }
}
