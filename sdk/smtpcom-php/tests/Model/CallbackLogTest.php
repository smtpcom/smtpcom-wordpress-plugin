<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\CallbackLog;

/**
 * Class CallbackLogTest
 */
class CallbackLogTest extends TestCase
{
    /**
     * @dataProvider callbackLogProvider
     * @param array $data
     */
    public function testCallbackLog(array $data)
    {
        $channelLogObject = new CallbackLog($data);

        $this->assertEquals($data, [
            'code' => $channelLogObject->getCode(),
            'msg' => $channelLogObject->getMsg(),
            'time' => date('r', $channelLogObject->getTime())
        ]);
    }

    /**
     * @return array
     */
    public function callbackLogProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "code": 0,
                "msg": "HTTP or AWS SQS response message from the server",
                "time": "Fri, 13 Aug 2021 10:24:49 +0000"
            }
        }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
