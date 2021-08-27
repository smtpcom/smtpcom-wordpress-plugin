<?php

declare(strict_types=1);

namespace SmtpSdk\Exception;

use Psr\Http\Message\ResponseInterface;
use SmtpSdk\SmtpSdkException;

class HttpException extends SmtpSdkException
{
    public static function badRequest(ResponseInterface $response)
    {
        return new self('Query or path params invalid. Response: ' . $response->getBody()->getContents());
    }

    public static function unauthorized()
    {
        return new self('Invalid API Key');
    }

    public static function serverError()
    {
        return new self('API server error');
    }

    public static function unknownHttpCode(int $code)
    {
        return new self('Unknown HTTP code ' . $code);
    }
}
