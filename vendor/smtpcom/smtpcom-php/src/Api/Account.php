<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Response\Account\UpdateResponse;
use SmtpSdk\SmtpSdkException;
use SmtpSdk\Model\Account as AccountModel;

class Account
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * Account constructor.
     * @param HttpRequest $httpClient
     */
    public function __construct(HttpRequest $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get Account Details
     * @return AccountModel
     * @throws SmtpSdkException
     */
    public function show(): AccountModel
    {
        $response = $this->httpClient->request('GET', 'account');

        return new AccountModel($response['data']);
    }

    /**
     * @param array $parameters
     * @return UpdateResponse
     * @throws SmtpSdkException
     */
    public function update(array $parameters): UpdateResponse
    {
        $response = $this->httpClient->request('PATCH', 'account', $parameters);

        return UpdateResponse::create($response['data']);
    }
}
