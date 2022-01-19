<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\Callbacks\IndexResponse;
use SmtpSdk\Model\Callback;

/**
 * Class CallbackIndexTest
 */
class CallbackIndexTest extends TestCase
{
    /**
     * @dataProvider callbackProvider
     *
     * @param array $data
     */
    public function testIndex(array $data)
    {
        $responseObject = IndexResponse::create($data);

        foreach ($responseObject->getItems() as $item) {
            $this->assertInstanceOf(Callback::class, $item);
        }
        $this->assertCount(2, $responseObject->getItems());
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
                "items": [
                    {
                        "channel": "testVlad",
                        "event": "delivered",
                        "medium": "http",
                        "address": "https://google2.com.ua/",
                        "aws_data": null
                    },
                    {
                        "channel": "testDima",
                        "event": "delivered",
                        "medium": "http",
                        "address": "https://google1.com.ua/",
                        "aws_data": null
                    }
                ] 
            }
        }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
