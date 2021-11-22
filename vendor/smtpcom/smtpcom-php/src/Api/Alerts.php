<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Model\Alert;
use SmtpSdk\Response\Alerts\IndexResponse;
use SmtpSdk\SmtpSdkException;

class Alerts
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * @var string
     */
    private $alertId;

    /**
     * Alerts constructor.
     * @param HttpRequest $httpClient
     * @param string $alertId
     */
    public function __construct(HttpRequest $httpClient, string $alertId)
    {
        $this->httpClient = $httpClient;
        $this->alertId = $alertId;
    }

    /**
     * List All Allerts
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(): IndexResponse
    {
        $response = $this->httpClient->request('GET', 'alerts');

        return IndexResponse::create($response['data']);
    }

    /**
     * Create New Alert
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function create(array $parameters): bool
    {
        $this->httpClient->request('POST', 'alerts', $parameters);

        return true;
    }

    /**
     * Get Alert Details
     * @return Alert
     * @throws SmtpSdkException
     */
    public function show(): Alert
    {
        Assertion::notEmpty($this->alertId, 'Alert ID is not specified.');
        $response = $this->httpClient->request('GET', "alerts/{$this->alertId}");

        return new Alert($response['data']);
    }

    /**
     * Delete Alert
     * @return bool
     * @throws SmtpSdkException
     */
    public function delete(): bool
    {
        Assertion::notEmpty($this->alertId, 'Alert ID is not specified.');
        $this->httpClient->request('DELETE', "alerts/{$this->alertId}");

        return true;
    }

    /**
     * Update Alert Details
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function update(array $parameters): bool
    {
        $this->httpClient->request('PATCH', "alerts/{$this->alertId}", $parameters);

        return true;
    }
}
