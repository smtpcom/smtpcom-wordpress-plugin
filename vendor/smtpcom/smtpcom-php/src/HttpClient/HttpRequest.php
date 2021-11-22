<?php

declare(strict_types=1);

namespace SmtpSdk\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Exception;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;
use SmtpSdk\Exception\DecodeException;
use SmtpSdk\Exception\HttpClientException;
use SmtpSdk\Exception\HttpException;
use SmtpSdk\SmtpSdkException;

class HttpRequest
{
    /**
     * @var HttpMethodsClient
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
     * @param HttpMethodsClient|null $client
     */
    public function __construct(
        string $apiKey,
        string $apiUrl,
        string $apiVersion,
        HttpMethodsClientInterface $client = null
    ) {
        $this->client = $client ?: new HttpMethodsClient(
            HttpClientDiscovery::find(),
            MessageFactoryDiscovery::find()
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
    public function request(string $method, string $uri, array $data = null): array
    {
        try {
            $response = $this->client->send(
                strtoupper($method),
                $this->baseUri . $uri,
                $this->headers,
                !empty($data) ? json_encode($data) : null
            );
        } catch (Exception $exception) {
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
