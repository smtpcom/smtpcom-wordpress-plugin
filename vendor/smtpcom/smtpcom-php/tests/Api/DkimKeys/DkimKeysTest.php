<?php

namespace SmtpSdk\Tests\Api\DkimKeys;

use PHPUnit\Framework\Attributes\DataProvider;
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

        $api = $this->getApiInstance(DkimKeys::class, 'channelName');
        $response = $api->show();

        $this->assertInstanceOf(DkimKey::class, $response);
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
                    "selector": "Name of the DKIM selector",
                    "private_key": "Private key of the DKIM record",
                    "is_valid": false
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

        $api = $this->getApiInstance(DkimKeys::class, 'channelName');
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
    #[DataProvider('createProvider')]
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
    public static function createProvider()
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

        $api = $this->getApiInstance(DkimKeys::class, 'channelName');
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
}
