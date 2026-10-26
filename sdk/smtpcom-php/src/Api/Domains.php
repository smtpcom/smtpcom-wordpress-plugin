<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Model\Domain;
use SmtpSdk\Response\Domains\IndexResponse;
use SmtpSdk\SmtpSdkException;

class Domains
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
     * Domains constructor.
     * @param HttpRequest $httpClient
     * @param string $name
     */
    public function __construct(HttpRequest $httpClient, string $name)
    {
        $this->httpClient = $httpClient;
        $this->name = $name;
    }

    /**
     * Get All Registered Domains
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(): IndexResponse
    {
        $response = $this->httpClient->request('GET', 'domains');

        return IndexResponse::create($response['data']);
    }

    /**
     * Register a Domain
     * @return bool
     * @throws SmtpSdkException
     */
    public function create(): bool
    {
        Assertion::notEmpty($this->name, 'Domain name not specified.');
        $this->httpClient->request('POST', 'domains', ['domain_name' => $this->name]);

        return true;
    }

    /**
     * Get Domain Details
     * @return Domain
     * @throws SmtpSdkException
     */
    public function show(): Domain
    {
        Assertion::notEmpty($this->name, 'Domain name not specified.');
        $response = $this->httpClient->request('GET', "domains/{$this->name}");

        return new Domain($response['data']);
    }

    /**
     * Delete Domain
     * @return bool
     * @throws SmtpSdkException
     */
    public function delete(): bool
    {
        Assertion::notEmpty($this->name, 'Domain name not specified.');
        $this->httpClient->request('DELETE', "domains/{$this->name}");

        return true;
    }

    /**
     * Update Domain Details
     * @param array $parameters
     * @return bool
     * @throws SmtpSdkException
     */
    public function update(array $parameters): bool
    {
        Assertion::notEmpty($this->name, 'Domain name not specified.');
        $this->httpClient->request('PATCH', "domains/{$this->name}", $parameters);

        return true;
    }

    /**
     * Returns DkimKeys object
     * @return DkimKeys
     */
    public function dkim(): DkimKeys
    {
        return new DkimKeys($this->httpClient, $this->name);
    }
}
