<?php

declare(strict_types=1);

namespace SmtpSdk\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use SmtpSdk\Exception\DecodeException;
use SmtpSdk\Exception\HttpClientException;
use SmtpSdk\Exception\HttpException;
use SmtpSdk\SmtpSdkException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

class HttpRequest
{
    /**
     * @var HttpMethodsClientInterface
     */
    private $client;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * HttpClient constructor.
     * @param string $apiKey
     * @param string $apiUrl
     * @param string $apiVersion
     * @param HttpMethodsClientInterface|null $client
     */
    public function __construct(
        string $apiKey,
        string $apiUrl,
        string $apiVersion,
        ?HttpMethodsClientInterface $client = null
    ) {
        // Redirects are not followed: a 3xx must surface as an error instead of
        // being replayed (a redirected POST would turn into a body-less GET).
        $this->client = $client ?: new HttpMethodsClient(
            new Psr18Client(HttpClient::create(['max_redirects' => 0])),
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );
        $this->baseUri = "$apiUrl/$apiVersion/";
        $this->headers = [
            'Authorization' => 'Basic ' . base64_encode("api:$apiKey"),
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array|null $data
     * @return array
     * @throws SmtpSdkException
     */
    public function request(string $method, string $uri, ?array $data = null): array
    {
        try {
            $response = $this->client->send(
                strtoupper($method),
                $this->baseUri . $uri,
                $this->headers,
                !empty($data) ? json_encode($data) : null
            );
        } catch (ClientExceptionInterface $exception) {
            throw new HttpClientException($exception->getMessage());
        }

        $this->handleErrors($response);

        return $this->decodeResponse($response);
    }

    /**
     * @param ResponseInterface $response
     * @return bool
     * @throws HttpException
     */
    protected function handleErrors(ResponseInterface $response): bool
    {
        $statusCode = $response->getStatusCode();
        switch ($statusCode) {
            case 200:
                return true;
            case 400:
                throw HttpException::badRequest($response);
            case 401:
                throw HttpException::unauthorized();
            case 500 <= $statusCode:
                throw HttpException::serverError();
            default:
                throw HttpException::unknownHttpCode($statusCode);
        }
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws SmtpSdkException
     */
    public function decodeResponse(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();
        if (0 !== strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
            throw new DecodeException(
                'Cannot decode response with Content-Type:' . $response->getHeaderLine('Content-Type')
            );
        }

        $content = json_decode($body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new DecodeException(sprintf('Error (%d) when trying to json_decode response', json_last_error()));
        }

        return $content;
    }
}
