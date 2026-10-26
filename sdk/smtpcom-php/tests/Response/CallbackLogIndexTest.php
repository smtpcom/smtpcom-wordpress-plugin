<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\Callbacks\Logs\IndexResponse;
use SmtpSdk\Model\CallbackLog;

/**
 * Class CallbackLogIndexTest
 */
class CallbackLogIndexTest extends TestCase
{
    /**
     * @dataProvider callbackLogProvider
     *
     * @param array $data
     */
    public function testIndex(array $data)
    {
        $responseObject = IndexResponse::create($data);

        foreach ($responseObject->getItems() as $item) {
            $this->assertInstanceOf(CallbackLog::class, $item);
        }
        $this->assertCount(2, $responseObject->getItems());
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

        return [[json_decode($json, true)['data']]];
    }
}
