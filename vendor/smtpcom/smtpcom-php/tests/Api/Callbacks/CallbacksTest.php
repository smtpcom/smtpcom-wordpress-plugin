<?php

namespace SmtpSdk\Tests\Api\Callbacks;

use PHPUnit\Framework\Attributes\DataProvider;
use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Callbacks;
use SmtpSdk\Model\Callback;
use SmtpSdk\Response\Callbacks\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class CallbacksTest
 */

class CallbacksTest extends TestCase
{
    /**
     * @param string $data
     */
    #[DataProvider('indexProvider')]
    public function testIndex(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Callbacks::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);

        $this->assertInstanceOf(Callback::class, $response->getItems()[0]);
    }

    /**
     * @return string
     */
    public static function indexProvider()
    {

        $json =
            <<<'JSON'
            {
                "status": "success",
                "data": {
                    "items": [
                        {
                            "channel":"testVlad",
                            "event":"delivered",
                            "medium":"http",
                            "address":"https://google2.com.ua/",
                            "aws_data":"settings"
                        },
                        {
                            "channel":"testVlad2",
                            "event":"delivered",
                            "medium":"http",
                            "address":"https://google3.com.ua/",
                            "aws_data":"settings"
                        }
                    ]
                }
            }
JSON;

        return [[$json]];
    }


    /**
     * @param string $data
     */
    #[DataProvider('showProvider')]
    public function testShow(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Callbacks::class, 'channelName');
        $response = $api->type('delivered')->show();

        $this->assertInstanceOf(Callback::class, $response);
    }

    /**
     * @return string
     */
    public static function showProvider()
    {

        $json =
            <<<'JSON'
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

        return [[$json]];
    }


    /**
     * @param string $data
     */
    #[DataProvider('createProvider')]
    public function testCreate(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Callbacks::class, 'channelName');
        $response = $api->type('delivered')->create(json_decode($data, true));

        $this->assertEquals(true, $response);
    }

    /**
     * @return string
     */
    public static function createProvider()
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


    /**
     * @param string $data
     */
    #[DataProvider('updateProvider')]
    public function testUpdate(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Callbacks::class, 'channelName');
        $response = $api->type('delivered')->update(json_decode($data, true));

        $this->assertEquals(true, $response);
    }

    /**
     * @return string
     */
    public static function updateProvider()
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


    /**
     * @param string $data
     */
    #[DataProvider('deleteProvider')]
    public function testDelete(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Callbacks::class, 'channelName');
        $response = $api->type('delivered')->delete();

        $this->assertEquals(true, $response);
    }

    /**
     * @return string
     */
    public static function deleteProvider()
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


    /**
     * @param string $data
     */
    #[DataProvider('deleteAllProvider')]
    public function testDeleteAll(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Callbacks::class, 'channelName');
        $response = $api->type('delivered')->deleteAll();

        $this->assertEquals(true, $response);
    }

    /**
     * @return string
     */
    public static function deleteAllProvider()
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
