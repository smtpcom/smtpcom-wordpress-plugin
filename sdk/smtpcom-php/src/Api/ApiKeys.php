<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Model\ApiKey;
use SmtpSdk\Response\ApiKeys\IndexResponse;
use SmtpSdk\SmtpSdkException;

class ApiKeys
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * ApiKeys constructor.
     * @param HttpRequest $httpClient
     * @param string $apiKey
     */
    public function __construct(HttpRequest $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    /**
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(): IndexResponse
    {
        $response = $this->httpClient->request('GET', 'api_keys');

        return IndexResponse::create($response['data']);
    }

    /**
     * @param array $parameters
     * @return ApiKey
     * @throws SmtpSdkException
     */
    public function create(array $parameters): ApiKey
    {
        $response = $this->httpClient->request('POST', 'api_keys', $parameters);

        return new ApiKey($response['data']);
    }

    /**
     * @return bool
     * @throws SmtpSdkException
     */
    public function delete(): bool
    {
        Assertion::notEmpty($this->apiKey, 'Api key is not specified.');
        $this->httpClient->request('DELETE', "api_keys/{$this->apiKey}");

        return true;
    }

    /**
     * Get API Key Details
     * @return ApiKey
     * @throws SmtpSdkException
     */
    public function show(): ApiKey
    {
        Assertion::notEmpty($this->apiKey, 'Api key is not specified.');
        $response = $this->httpClient->request('GET', "api_keys/{$this->apiKey}");

        return new ApiKey($response['data']);
    }

    /**
     * @param array $parameters
     * @return ApiKey
     * @throws SmtpSdkException
     */
    public function update(array $parameters): ApiKey
    {
        Assertion::notEmpty($this->apiKey, 'Api key is not specified.');
        $response = $this->httpClient->request('PATCH', "api_keys/{$this->apiKey}", $parameters);

        return new ApiKey($response['data']);
    }
}
