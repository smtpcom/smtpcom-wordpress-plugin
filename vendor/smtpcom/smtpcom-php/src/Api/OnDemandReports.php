<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\SmtpSdkException;

/**
 * Class OnDemandReports
 * @package SmtpSdk\Api
 */
class OnDemandReports
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * OnDemandReports constructor.
     * @param HttpRequest $httpClient
     */
    public function __construct(HttpRequest $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Create On-Demand report
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function create(array $parameters): bool
    {
        $this->httpClient->request('POST', 'reports/ondemand', $parameters);

        return true;
    }
}
