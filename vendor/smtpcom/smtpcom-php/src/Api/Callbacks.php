<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Model\Callback;
use SmtpSdk\Response\Callbacks\IndexResponse;
use SmtpSdk\SmtpSdkException;

class Callbacks
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * @var string
     */
    private $channelName;

    /**
     * @var string
     */
    private $eventType;

    /**
     * Callbacks constructor.
     * @param HttpRequest $httpClient
     * @param string $channelName
     */
    public function __construct(HttpRequest $httpClient, string $channelName)
    {
        $this->httpClient = $httpClient;
        $this->channelName = $channelName;
    }

    /**
     * Set event type
     * @param string $event
     * @return $this
     */
    public function type(string $event): self
    {
        $this->eventType = $event;

        return $this;
    }

    /**
     * List All Callbacks
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(): IndexResponse
    {
        $response = $this->httpClient->request('GET', 'callbacks');

        return IndexResponse::create($response['data']);
    }

    /**
     * Delete All Callbacks
     * @return bool
     * @throws SmtpSdkException
     */
    public function deleteAll(): bool
    {
        $this->httpClient->request('DELETE', 'callbacks');

        return true;
    }

    /**
     * Get Callback Details
     * @return Callback
     * @throws SmtpSdkException
     */
    public function show(): Callback
    {
        Assertion::notEmpty($this->channelName, 'Channel name is not specified');
        Assertion::notEmpty($this->eventType, 'Event type is not specified');

        $parameters = ['channel' => $this->channelName];
        $uri = "callbacks/{$this->eventType}?" . urldecode(http_build_query($parameters));
        $response = $this->httpClient->request('GET', $uri);

        return new Callback($response['data']);
    }

    /**
     * Create Callback
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function create(array $parameters): bool
    {
        Assertion::notEmpty($this->channelName, 'Channel name is not specified');
        Assertion::notEmpty($this->eventType, 'Event type is not specified');

        $parameters['channel'] = $this->channelName;
        $this->httpClient->request('POST', "callbacks/{$this->eventType}", $parameters);

        return true;
    }

    /**
     * Delete Callback
     * @return bool
     * @throws SmtpSdkException
     */
    public function delete(): bool
    {
        Assertion::notEmpty($this->channelName, 'Channel name is not specified');
        Assertion::notEmpty($this->eventType, 'Event type is not specified');

        $parameters = ['channel' => $this->channelName];
        $this->httpClient->request('DELETE', "callbacks/{$this->eventType}", $parameters);

        return true;
    }

    /**
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function update(array $parameters): bool
    {
        Assertion::notEmpty($this->channelName, 'Channel name is not specified');
        Assertion::notEmpty($this->eventType, 'Event type is not specified');

        $parameters['channel'] = $this->channelName;
        $this->httpClient->request('PATCH', "callbacks/{$this->eventType}", $parameters);

        return true;
    }

    /**
     * Returns CallbackLogs object
     * @return CallbackLogs
     */
    public function logs(): CallbackLogs
    {
        return new CallbackLogs($this->httpClient, $this->channelName);
    }
}
