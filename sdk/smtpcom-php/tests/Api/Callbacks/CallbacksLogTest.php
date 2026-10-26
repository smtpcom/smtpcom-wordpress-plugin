<?php

namespace SmtpSdk\Tests\Api\Callbacks;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\CallbackLogs;
use SmtpSdk\Model\CallbackLog;
use SmtpSdk\Response\Callbacks\Logs\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class CallbacksLogTest
 */

class CallbacksLogTest extends TestCase
{
    /**
     * @dataProvider indexProvider
     * @param string $data
     */
    public function testIndex(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(CallbackLogs::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(CallbackLog::class, $response->getItems()[0]);
    }

    /**
     * @return string
     */
    public function indexProvider()
    {

        $json =
            <<<'JSON'
            {
                "status": "success",
                "data": {
                    "items": [
                        {
                            "code": 0,
                            "msg": "HTTP or AWS SQS response message from the server",
                            "time": "Wed, 11 Aug 2021 14:26:20 -0000"
                        },
                        {
                            "code": 0,
                            "msg": "HTTP or AWS SQS response message from the server2",
                            "time": "Fri, 13 Aug 2021 14:26:20 -0000"
                        }
                    ]
                }
            }
JSON;

        return [[$json]];
    }
}
