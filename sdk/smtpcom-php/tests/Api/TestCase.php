<?php

namespace SmtpSdk\Tests\Api;

use GuzzleHttp\Psr7\Response;
use Http\Client\Common\HttpMethodsClientInterface;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Http\Message\ResponseInterface;
use SmtpSdk\HttpClient\HttpRequest;

class TestCase extends BaseTestCase
{
    /**
     * @var string
     */
    protected $httpResponse = null;

    /**
     * @param ResponseInterface $httpResponse
     */
    public function setHttpResponse(ResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    /**
     * @param string $class
     * @param mixed $parameter
     * @return mixed
     */
    protected function getApiInstance(string $class, $parameter = null)
    {
        $httpMethodsClient = $this->getMockBuilder(HttpMethodsClientInterface::class)
            ->setMethods(['send', 'get', 'head', 'trace', 'post', 'put', 'patch', 'delete', 'options', 'sendRequest'])
            ->getMock();

        $httpMethodsClient
            ->method('send')
            ->willReturn($this->httpResponse ?: new Response());

        $httpRequest = new HttpRequest('apiKey', 'https://api.smtp.com', 'v4', $httpMethodsClient);

        if ($parameter !== null) {
            return new $class($httpRequest, $parameter);
        }

        return new $class($httpRequest);
    }
}
