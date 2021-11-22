<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Response\Callbacks\Logs\IndexResponse;

class CallbackLogs
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
     * CallbackLogs constructor.
     * @param HttpRequest $httpClient
     * @param string $channelName
     */
    public function __construct(HttpRequest $httpClient, string $channelName)
    {
        $this->httpClient = $httpClient;
        $this->channelName = $channelName;
    }

    /**
     * View Callback Logs
     * @param array $parameters
     * @return IndexResponse
     * @throws \SmtpSdk\SmtpSdkException
     */
    public function index(array $parameters = []): IndexResponse
    {
        Assertion::notEmpty($this->channelName, 'Channel name is not specified');
        $parameters['channel'] = $this->channelName;
        $uri = 'callbacks/log?' . urldecode(http_build_query($parameters));
        $response = $this->httpClient->request('GET', $uri);

        return IndexResponse::create($response['data']);
    }
}
