<?php

declare(strict_types=1);

namespace SmtpSdk\Api;

use SmtpSdk\Assertion;
use SmtpSdk\HttpClient\HttpRequest;
use SmtpSdk\Response\Message\CreateResponse;
use SmtpSdk\Response\Message\IndexResponse;
use SmtpSdk\SmtpSdkException;

/**
 * Class Messages
 * @package SmtpSdk\Api
 */
class Messages
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
     * Messages constructor.
     * @param HttpRequest $httpClient
     * @param string $channelName
     * @throws SmtpSdkException
     */
    public function __construct(HttpRequest $httpClient, string $channelName)
    {
        Assertion::notEmpty($channelName, 'Channel name is not specified.');
        $this->httpClient = $httpClient;
        $this->channelName = $channelName;
    }

    /**
     * @param array $parameters
     * @return IndexResponse
     * @throws SmtpSdkException
     */
    public function index(array $parameters): IndexResponse
    {
        Assertion::parameterExists($parameters, 'start');
        Assertion::parameterExists($parameters, 'limit');
        Assertion::parameterExists($parameters, 'offset');
        Assertion::keysInArray($parameters, ['start', 'end', 'event', 'limit', 'offset', 'msg_id']);

        $parameters['channel'] = $this->channelName;
        $uri = 'messages?' . urldecode(http_build_query($parameters));
        $response = $this->httpClient->request('GET', $uri);

        return IndexResponse::create($response['data']);
    }

    /**
     * @param mixed $parametersOrFrom
     * @param mixed $to
     * @param string $subject
     * @param string $body
     * @param array $attachments
     * @return CreateResponse
     * @throws SmtpSdkException
     */
    public function create(
        $parametersOrFrom,
        $to = [],
        string $subject = '',
        string $body = '',
        array $attachments = []
    ): CreateResponse {
        if (func_num_args() === 1) {
            $requestBody = $parametersOrFrom;
        } else {
            $requestBody = $this->createRequestBody($parametersOrFrom, $to, $subject, $body, $attachments);
        }
        $requestBody['channel'] = $this->channelName;
        $response = $this->httpClient->request('POST', 'messages', $requestBody);

        return CreateResponse::create($response['data']);
    }

    /**
     * @param mixed $parametersOrFrom
     * @param array $to
     * @param string $mime
     * @return CreateResponse
     * @throws SmtpSdkException
     */
    public function createMime($parametersOrFrom, $to = [], string $mime = ''): CreateResponse
    {
        if (func_num_args() === 1) {
            $requestBody = $parametersOrFrom;
        } else {
            $requestBody = $this->createMimeRequestBody($parametersOrFrom, $to, $mime);
        }
        $requestBody['channel'] = $this->channelName;
        $response = $this->httpClient->request('POST', 'messages/mime', $requestBody);

        return CreateResponse::create($response['data']);
    }

    /**
     * @param mixed $from
     * @param mixed $to
     * @param string $subject
     * @param string $body
     * @param array $attachments
     * @return array
     * @throws SmtpSdkException
     */
    private function createRequestBody($from, $to, string $subject, string $body, array $attachments): array
    {
        $requestBody = [
            'recipients' => ['to' => $this->formatTo($to)],
            'originator' => ['from' => $this->formatFrom($from)],
            'subject'    => $subject,
            'body'       => ['parts' => [['content' => $body]]]
        ];
        if (!empty($attachments)) {
            $requestBody['attachments'] = $attachments;
        }

        return $requestBody;
    }

    /**
     * @param mixed $from
     * @param mixed $to
     * @param string $mime
     * @return array
     * @throws SmtpSdkException
     */
    private function createMimeRequestBody($from, $to, string $mime): array
    {
        return [
            'recipients' => ['to' => $this->formatTo($to)],
            'originator' => ['from' => $this->formatFrom($from)],
            'mime'       => $mime
        ];
    }

    /**
     * @param mixed $from
     * @return array
     * @throws SmtpSdkException
     */
    private function formatFrom($from): array
    {
        $formattedFrom = [];
        if (is_array($from)) {
            Assertion::keyIsset($from, 'address', 'Sender email not specified.');
            Assertion::string($from['address'], 'Sender email should be a string.');
            $formattedFrom['address'] = $from['address'];
            if (!empty($from['name'])) {
                Assertion::string($from['name'], 'Sender name should be a string.');
                $formattedFrom['name'] = $from['name'];
            }
        } else {
            Assertion::string($from, 'Sender email should be a string.');
            $formattedFrom = ['address' => $from];
        }

        return $formattedFrom;
    }

    /**
     * @param mixed $to
     * @return array
     * @throws SmtpSdkException
     */
    private function formatTo($to): array
    {
        $formattedTo = [];
        if (is_array($to)) {
            foreach ($to as $email) {
                Assertion::string($email, 'Recipient email should be a string.');
                $formattedTo[] = ['address' => $email];
            }
        } else {
            Assertion::string($to, 'Recipient email should be a string.');
            $formattedTo[] = ['address' => $to];
        }

        return $formattedTo;
    }
}
