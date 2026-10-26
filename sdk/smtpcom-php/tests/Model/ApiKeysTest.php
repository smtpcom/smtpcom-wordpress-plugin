<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\ApiKey;

/**
 * Class ApiKeysTest
 */

class ApiKeysTest extends TestCase
{
    /**
    * @dataProvider keysProvider
    * @param array $data
    */
    public function testApiKey(array $data)
    {
        $apikeysObject = new ApiKey($data);

        $this->assertEquals($data, [
            "name" => $apikeysObject->getName(),
            "status" => $apikeysObject->getStatus(),
            "description" => $apikeysObject->getDescription(),
            "key" => $apikeysObject->getKey(),
            "created_date" => $apikeysObject->getCreatedDate(),
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
                    "name":"test_test",
                    "status":"active",
                    "description":"test_test",
                    "key":"1a8a6a0249656d928a44dd8e818318876733114c",
                    "created_date":"1628684777"
                }
            }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
