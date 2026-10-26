<?php

declare(strict_types=1);

namespace SmtpSdk\Exception;

use Psr\Http\Message\ResponseInterface;
use SmtpSdk\SmtpSdkException;

final class HttpException extends SmtpSdkException
{
    public static function badRequest(ResponseInterface $response): self
    {
        return new self('Query or path params invalid. Response: ' . $response->getBody()->getContents());
    }

    public static function unauthorized(): self
    {
        return new self('Invalid API Key');
    }

    public static function serverError(): self
    {
        return new self('API server error');
    }

    public static function unknownHttpCode(int $code): self
    {
        return new self('Unknown HTTP code ' . $code);
    }
}
