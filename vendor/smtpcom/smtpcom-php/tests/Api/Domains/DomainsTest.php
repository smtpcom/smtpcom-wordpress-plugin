<?php

namespace SmtpSdk\Tests\Api\Domains;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Domains;
use SmtpSdk\Model\Domain;
use SmtpSdk\Response\Domains\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class DomainsTest
 */

class DomainsTest extends TestCase
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);

        $this->assertInstanceOf(Domain::class, $response->getItems()[0]);
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
                            "domain_name": "test.com",
                            "enabled": false
                        },
                        {
                            "domain_name": "test2.com",
                            "enabled": true
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
        $response = $api->show();

        $this->assertInstanceOf(Domain::class, $response);
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
                    "domain_name": "test.com",
                    "enabled": true
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
        $response = $api->update(json_decode($data, true));

        $this->assertEquals(true, $response);
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
                "data": {}
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
        $response = $api->create(json_decode($data, true));

        $this->assertEquals(true, $response);
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
                    "domain_name": "example"
                }
            }
JSON;

        return [[$json]];
    }
}
