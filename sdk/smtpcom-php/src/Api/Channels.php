<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Model\Channel;
use SmtpSdk\Response\Channels\IndexResponse;
use SmtpSdk\SmtpSdkException;

class Channels
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * @var string
     */
    private $name;

    /**
     * Channels constructor.
     * @param HttpRequest $httpClient
     * @param string $name
     */
    public function __construct(HttpRequest $httpClient, string $name)
    {
        $this->httpClient = $httpClient;
        $this->name = $name;
    }

    /**
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(): IndexResponse
    {
        $response = $this->httpClient->request('GET', 'channels');

        return IndexResponse::create($response['data']);
    }

    /**
     * @param array $parameters
     * @return Channel
     * @throws SmtpSdkException
     */
    public function create(array $parameters): Channel
    {
        Assertion::notEmpty($this->name, 'Channel name is not specified.');
        $parameters['name'] = $this->name;
        $response = $this->httpClient->request('POST', 'channels', $parameters);

        return new Channel($response['data']['items']);
    }

    /**
     * @return Channel
     * @throws SmtpSdkException
     */
    public function show(): Channel
    {
        Assertion::notEmpty($this->name, 'Channel name is not specified.');
        $response = $this->httpClient->request('GET', "channels/{$this->name}");

        return new Channel($response['data']);
    }

    /**
     * @return Channel
     * @throws SmtpSdkException
     */
    public function delete(): Channel
    {
        Assertion::notEmpty($this->name, 'Channel name is not specified.');
        $response = $this->httpClient->request('DELETE', "channels/{$this->name}");

        return new Channel($response['data']);
    }

    /**
     * @param array $parameters
     * @return Channel
     * @throws SmtpSdkException
     */
    public function update(array $parameters): Channel
    {
        Assertion::notEmpty($this->name, 'Channel name is not specified.');
        $parameters['name'] = $this->name;
        $response = $this->httpClient->request('PATCH', "channels/{$this->name}", $parameters);

        return new Channel($response['data']);
    }
}
