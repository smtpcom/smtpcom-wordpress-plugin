<?php

namespace SmtpSdk\Tests\Api\ApiKeys;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\ApiKeys;
use SmtpSdk\Model\ApiKey;
use SmtpSdk\Response\ApiKeys\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class ApiKeysTest
 */
class ApiKeysTest extends TestCase
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

        $api = $this->getApiInstance(ApiKeys::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);

        $this->assertInstanceOf(ApiKey::class, $response->getItems()[0]);
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
        return [[$json]];
    }


    /**
     * @dataProvider showProvider
     * @param string $data
     */
    public function testShow(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(ApiKeys::class, 'channelName');
        $response = $api->show();

        $this->assertInstanceOf(ApiKey::class, $response);
    }

    /**
     * @return string
     */
    public function showProvider()
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

        return [[$json]];
    }


    /**
     * @dataProvider updateProvider
     * @param string $data
     */
    public function testUpdate(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(ApiKeys::class, 'channelName');
        $response = $api->update(json_decode($data, true));

        $this->assertInstanceOf(ApiKey::class, $response);
    }

    /**
     * @return string
     */
    public function updateProvider()
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

        return [[$json]];
    }


    /**
     * @dataProvider createProvider
     * @param string $data
     */
    public function testCreate(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(ApiKeys::class, 'channelName');
        $response = $api->create(json_decode($data, true));

        $this->assertInstanceOf(ApiKey::class, $response);
    }

    /**
     * @return string
     */
    public function createProvider()
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

        return [[$json]];
    }


    /**
     * @dataProvider deleteProvider
     * @param string $data
     */
    public function testDelete(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(ApiKeys::class, 'channelName');
        $response = $api->delete();

        $this->assertEquals(true, $response);
    }

    /**
     * @return string
     */
    public function deleteProvider()
    {

        $json =
            <<<'JSON'
            {
                "status": "success",
                "data": {}
            }
JSON;

        return [[$json]];
    }
}
