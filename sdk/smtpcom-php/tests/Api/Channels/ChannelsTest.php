<?php

namespace SmtpSdk\Tests\Api\Channels;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Channels;
use SmtpSdk\Model\Channel;
use SmtpSdk\Response\Channels\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class ChannelsTest
 */
class ChannelsTest extends TestCase
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

        $api = $this->getApiInstance(Channels::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(Channel::class, $response->getItems()[0]);
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

        $api = $this->getApiInstance(Channels::class, 'channelName');

        $response = $api->show();

        $this->assertInstanceOf(Channel::class, $response);
        $this->assertEquals(json_decode($data, true)['data'], [
            "name" => $response->getName(),
            "status" => $response->getStatus(),
            "quota" => $response->getQuota(),
            "label" => $response->getLabel(),
            "usage" => $response->getUsage(),
            "date_created" => date('r', $response->getDateCreated()),
            "smtp_username" => $response->getSmtpUsername()
        ]);
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

        $api = $this->getApiInstance(Channels::class, 'testNameData');

        $response = $api->update(json_decode($data, true));

        $this->assertInstanceOf(Channel::class, $response);

        $this->assertEquals(json_decode($data, true)['data'], [
            "name" => $response->getName(),
            "status" => $response->getStatus(),
            "quota" => $response->getQuota(),
            "label" => $response->getLabel(),
            "usage" => $response->getUsage(),
            "date_created" => date('r', $response->getDateCreated()),
            "smtp_username" => $response->getSmtpUsername()
        ]);
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

        $api = $this->getApiInstance(Channels::class, 'testVlad');

        $response = $api->create(json_decode($data, true));

        $this->assertInstanceOf(Channel::class, $response);
        $this->assertEquals(json_decode($data, true)['data']['items'], [
            "name" => $response->getName(),
            "status" => $response->getStatus(),
            "quota" => $response->getQuota(),
            "label" => $response->getLabel(),
            "usage" => $response->getUsage(),
            "date_created" => date('r', $response->getDateCreated()),
            "smtp_username" => $response->getSmtpUsername()
        ]);
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

        $api = $this->getApiInstance(Channels::class, 'testVlad');

        $response = $api->delete();

        $this->assertInstanceOf(Channel::class, $response);
        $this->assertEquals(json_decode($data, true)['data'], [
            "name" => $response->getName(),
            "status" => $response->getStatus(),
            "quota" => $response->getQuota(),
            "label" => $response->getLabel(),
            "usage" => $response->getUsage(),
            "date_created" => date('r', $response->getDateCreated()),
            "smtp_username" => $response->getSmtpUsername()
        ]);
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
                            "smtp_username": "test1",
                            "quota": 5,
                            "usage": 1,
                            "name": "test1",
                            "date_created": "Wed, 11 Aug 2021 14:07:09 -0000",
                            "status": "active"
                        },
                        {
                            "smtp_username": "test2",
                            "quota": 5,
                            "usage": 0,
                            "name": "test2",
                            "date_created": "Wed, 11 Aug 2021 14:26:42 -0000",
                            "status": "canceled"
                        }
                    ]
                }
            }
JSON;

        return [[$json]];
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
                    "name": "testVlad",
                    "status": "active",
                    "quota": 30,
                    "label":"testLabel",
                    "usage": 1,
                    "date_created": "Wed, 11 Aug 2021 14:26:20 +0000",
                    "smtp_username": "username"
                }
            }
JSON;
        return [[$json]];
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
                    "name":"channelName",
                    "status":"active",
                    "quota":15,
                    "label":"testLabel",
                    "usage":0,
                    "date_created":"Wed, 11 Aug 2021 14:26:20 +0000",
                    "smtp_username":"username2"
                }
            }
JSON;
        return [[$json]];
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
                    "items":
                        {
                            "name":"testVlad",
                            "status":"active",
                            "quota":15,
                            "label":"testLabel",
                            "usage":0,
                            "date_created":"Wed, 11 Aug 2021 14:26:20 +0000",
                            "smtp_username":"username2"
                     }
                }
            }
JSON;
        return [[$json]];
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
                "data": {
                    "name":"testVlad",
                    "status":"active",
                    "quota":15,
                    "label":"testLabel",
                    "usage":0,
                    "date_created":"Wed, 11 Aug 2021 14:26:20 +0000",
                    "smtp_username":"username2"
                }
            }
JSON;
        return [[$json]];
    }
}
