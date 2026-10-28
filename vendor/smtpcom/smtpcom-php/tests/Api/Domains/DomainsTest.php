<?php

namespace SmtpSdk\Tests\Api\Domains;

use PHPUnit\Framework\Attributes\DataProvider;
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);

        $this->assertInstanceOf(Domain::class, $response->getItems()[0]);
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
        $response = $api->show();

        $this->assertInstanceOf(Domain::class, $response);
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
                    "domain_name": "test.com",
                    "enabled": true
                }
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

        $api = $this->getApiInstance(Domains::class, 'channelName');
        $response = $api->delete();

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
    #[DataProvider('updateProvider')]
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
    #[DataProvider('createProvider')]
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
    public static function createProvider()
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
