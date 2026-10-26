<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Model\DkimKey;
use SmtpSdk\SmtpSdkException;

class DkimKeys
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * @var string
     */
    private $domainName;

    /**
     * DkimKeys constructor.
     * @param HttpRequest $httpClient
     * @param string $domainName
     */
    public function __construct(HttpRequest $httpClient, string $domainName)
    {
        Assertion::notEmpty($domainName, 'Domain name not specified.');
        $this->httpClient = $httpClient;
        $this->domainName = $domainName;
    }

    /**
     * Get DKIM for Domain
     * @return DkimKey
     * @throws SmtpSdkException
     */
    public function show(): DkimKey
    {
        $response = $this->httpClient->request('GET', "domains/{$this->domainName}/dkim_keys");

        return new DkimKey($response['data']);
    }

    /**
     * Add DKIM for Domain
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function create(array $parameters): bool
    {
        $this->httpClient->request('POST', "domains/{$this->domainName}/dkim_keys", $parameters);

        return true;
    }

    /**
     * Delete DKIM for Domain
     * @return bool
     * @throws SmtpSdkException
     */
    public function delete(): bool
    {
        $this->httpClient->request('DELETE', "domains/{$this->domainName}/dkim_keys");

        return true;
    }

    /**
     * Update DKIM Key Details
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function update(array $parameters): bool
    {
        $this->httpClient->request('PATCH', "domains/{$this->domainName}/dkim_keys", $parameters);

        return true;
    }
}
