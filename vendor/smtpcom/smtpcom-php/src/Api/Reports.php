<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Model\CommonReport;
use SmtpSdk\Response\Reports\IndexResponse;
use SmtpSdk\SmtpSdkException;

/**
 * Class Reports
 * @package SmtpSdk\Api
 */
class Reports
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
     * Reports constructor.
     * @param HttpRequest $httpClient
     * @param string $reportId
     */
    public function __construct(HttpRequest $httpClient, string $reportId)
    {
        $this->httpClient = $httpClient;
        $this->reportId = $reportId;
    }

    /**
     * Returns on demand report object
     * @return OnDemandReports
     */
    public function onDemand(): OnDemandReports
    {
        return new OnDemandReports($this->httpClient);
    }

    /**
     * Returns periodic report object
     * @param string $reportId
     * @return PeriodicReports
     */
    public function periodic(string $reportId = ''): PeriodicReports
    {
        return new PeriodicReports($this->httpClient, $reportId);
    }

    /**
     * Get all reports
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(): IndexResponse
    {
        $response = $this->httpClient->request('GET', 'reports');

        return IndexResponse::create($response['data']);
    }

    /**
     * Get Report Details
     * @return CommonReport
     * @throws SmtpSdkException
     * @throws \Assert\AssertionFailedException
     */
    public function show(): CommonReport
    {
        Assertion::notEmpty($this->reportId, 'Report ID is not specified.');
        $response = $this->httpClient->request('GET', "reports/{$this->reportId}");

        return new CommonReport($response['data']);
    }
}
