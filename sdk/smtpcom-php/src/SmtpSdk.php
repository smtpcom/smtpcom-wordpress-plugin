<?php

declare(strict_types=1);

namespace SmtpSdk;

use SmtpSdk\HttpClient\HttpRequest;

/**
 * Class SmtpSdk
 * @package SmtpSdk
 */
class SmtpSdk
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiUrl = 'https://api.smtp.com';

    /**
     * @var string
     */
    private $apiVersion = 'v4';

    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * SmtpSdk constructor.
     * @param string $apiKey
     * @param string $apiUrl
     * @param string $apiVersion
     */
    private function __construct(string $apiKey, string $apiUrl = '', string $apiVersion = '')
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl ?: $this->apiUrl;
        $this->apiVersion = $apiVersion ?: $this->apiVersion;
        $this->httpClient = new HttpRequest($this->apiKey, $this->apiUrl, $this->apiVersion);
    }

    /**
     * @param string $apiKey
     * @param string $apiUrl
     * @param string $apiVersion
     * @return self
     */
    public static function create(string $apiKey, string $apiUrl = '', string $apiVersion = ''): self
    {
        return new self($apiKey, $apiUrl, $apiVersion);
    }

    /**
     * @return Api\Statistics
     */
    public function statistics(): Api\Statistics
    {
        return new Api\Statistics($this->httpClient);
    }

    /**
     * @return Api\Account
     */
    public function account(): Api\Account
    {
        return new Api\Account($this->httpClient);
    }

    /**
     * @param string $name
     * @return Api\Channels
     */
    public function channels(string $name = ''): Api\Channels
    {
        return new Api\Channels($this->httpClient, $name);
    }

    /**
     * @param string $apiKey
     * @return Api\ApiKeys
     */
    public function keys(string $apiKey = ''): Api\ApiKeys
    {
        return new Api\ApiKeys($this->httpClient, $apiKey);
    }

    /**
     * @param string $reportId
     * @return Api\Reports
     */
    public function reports(string $reportId = ''): Api\Reports
    {
        return new Api\Reports($this->httpClient, $reportId);
    }

    /**
     * @param string $alertId
     * @return Api\Alerts
     */
    public function alerts(string $alertId = ''): Api\Alerts
    {
        return new Api\Alerts($this->httpClient, $alertId);
    }

    /**
     * @param string $name
     * @return Api\Domains
     */
    public function domains(string $name = ''): Api\Domains
    {
        return new Api\Domains($this->httpClient, $name);
    }

    /**
     * @param string $channelName
     * @return Api\Callbacks
     */
    public function callbacks(string $channelName = ''): Api\Callbacks
    {
        return new Api\Callbacks($this->httpClient, $channelName);
    }

    /**
     * @param string $channelName
     * @return Api\Messages
     * @throws SmtpSdkException
     */
    public function messages(string $channelName): Api\Messages
    {
        return new Api\Messages($this->httpClient, $channelName);
    }
}
