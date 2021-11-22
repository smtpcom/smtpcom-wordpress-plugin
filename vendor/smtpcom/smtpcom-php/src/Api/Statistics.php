<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Response\Statistics\IndexResponse;
use SmtpSdk\SmtpSdkException;

class Statistics
{
    /**
     * @var HttpRequest
     */
    private $httpClient;

    /**
     * Statistics constructor.
     * @param HttpRequest $httpClient
     */
    public function __construct(HttpRequest $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Returns event aggregates for the specified slices and duration
     * @param array $parameters
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(array $parameters): IndexResponse
    {
        $uri = 'stats';
        if (isset($parameters['duration'])) {
            $uri .= '/' . $parameters['duration'];
            if (isset($parameters['slice'])) {
                $uri .= '/' . $parameters['slice'];
                if (isset($parameters['slice_specifier'])) {
                    $uri .= '/' . $parameters['slice_specifier'];
                    if (isset($parameters['group_by'])) {
                        $uri .= '/' . $parameters['group_by'];
                    }
                }
            }
        }
        unset($parameters['duration'], $parameters['slice'], $parameters['slice_specifier'], $parameters['group_by']);
        $uri .= '?' . urldecode(http_build_query($parameters));
        $response = $this->httpClient->request('GET', $uri);

        return IndexResponse::create($response['data']);
    }
}
