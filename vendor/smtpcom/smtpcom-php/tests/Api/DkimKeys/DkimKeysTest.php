<?php

namespace SmtpSdk\Tests\Api\DkimKeys;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\DkimKeys;
use SmtpSdk\Model\DkimKey;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class DkimKeysTest
 */

class DkimKeysTest extends TestCase
{

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

        $api = $this->getApiInstance(DkimKeys::class, 'channelName');
        $response = $api->show();

        $this->assertInstanceOf(DkimKey::class, $response);
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
                    "selector": "Name of the DKIM selector",
                    "private_key": "Private key of the DKIM record",
                    "is_valid": false
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

        $api = $this->getApiInstance(DkimKeys::class, 'channelName');
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

        $api = $this->getApiInstance(DkimKeys::class, 'channelName');
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
                    "dkim_key": "key_example"
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

        $api = $this->getApiInstance(DkimKeys::class, 'channelName');
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
}
