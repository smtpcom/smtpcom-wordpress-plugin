<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Callback;

/**
 * Class CallbackTest
 */
class CallbackTest extends TestCase
{
    /**
     * @dataProvider callbackProvider
     * @param array $data
     */
    public function testCallback(array $data)
    {
        $callbackObject = new Callback($data);

        $this->assertEquals($data, [
            'channel' => $callbackObject->getChannel(),
            'event' => $callbackObject->getEvent(),
            'medium' => $callbackObject->getMedium(),
            'address' => $callbackObject->getAddress(),
            'aws_data' => $callbackObject->getAwsData()
        ]);
    }

    /**
     * @return array
     */
    public function callbackProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "channel": "testChannel",
                "event": "delivered",
                "medium": "http",
                "address": "https://google2.com.ua/",
                "aws_data": null
            }
        }
JSON;
        return [[json_decode($json, true)['data']]];
    }
}
