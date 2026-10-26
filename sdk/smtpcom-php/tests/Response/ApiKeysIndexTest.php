<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\ApiKeys\IndexResponse;
use SmtpSdk\Model\ApiKey;

/**
 * Class ApiKeysIndexTest
*/
class ApiKeysIndexTest extends TestCase
{
    /**
     * @dataProvider keysProvider
     * @param int $count
     * @param array $data
     */
    public function testIndex(int $count, array $data)
    {
        $apikeysObject = IndexResponse::create($data);
        $this->assertCount($count, $apikeysObject->getItems());

        foreach ($apikeysObject->getItems() as $item) {
            $this->assertInstanceOf(ApiKey::class, $item);
        }

        $item = $apikeysObject->getItems()[0];
        $this->assertEquals($data['items'][0], [
            "name" => $item->getName(),
            "status" => $item->getStatus(),
            "description" => $item->getDescription(),
            "key" => $item->getKey(),
            "created_date" => $item->getCreatedDate(),
        ]);
    }

    /**
     * @return array
     */
    public function keysProvider()
    {
        $json =
        <<<'JSON'
        {
            "status": "success",
            "data": {
                "items": [
                    {
                        "name":"test_test",
                        "status":"active",
                        "description":"test_test",
                        "key":"1a8a6a0249656d928a44dd8e818318876733114c",
                        "created_date":"1628684777"
                    },
                    {
                        "name":"test11111",
                        "status":"active",
                        "description":"testDescription",
                        "key":"4a3bbff1017f5062cdf7978750452fffa91c3e28",
                        "created_date":"1628685392"
                    }
                ]
            }
        }
JSON;
        return [[count(json_decode($json, true)['data']['items']),json_decode($json, true)['data']]];
    }
}
