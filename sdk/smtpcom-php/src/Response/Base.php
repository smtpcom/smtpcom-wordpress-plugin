<?php

declare(strict_types=1);

namespace SmtpSdk\Response;

abstract class Base
{
    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * @param array $data
     * @return static
     */
    abstract public static function create($data);
}
