<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\SmtpSdkException;

/**
 * Class PeriodicReports
 * @package SmtpSdk\Api
 */
class PeriodicReports
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * @var string
     */
    private $reportId;

    /**
     * PeriodicReports constructor.
     * @param HttpRequest $httpClient
     * @param string $reportId
     */
    public function __construct(HttpRequest $httpClient, string $reportId)
    {
        $this->httpClient = $httpClient;
        $this->reportId = $reportId;
    }

    /**
     * Create Periodic Report
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function create(array $parameters): bool
    {
        $this->httpClient->request('POST', 'reports/periodic', $parameters);

        return true;
    }

    /**
     * Delete a Periodic Report
     * @return bool
     * @throws SmtpSdkException
     */
    public function delete(): bool
    {
        Assertion::notEmpty($this->reportId, 'Report ID is not specified.');
        $this->httpClient->request('DELETE', "reports/periodic/{$this->reportId}");

        return true;
    }

    /**
     * Update a Periodic Report
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function update(array $parameters): bool
    {
        Assertion::notEmpty($this->reportId, 'Report ID is not specified.');
        $this->httpClient->request('PATCH', "reports/periodic/{$this->reportId}", $parameters);

        return true;
    }
}
