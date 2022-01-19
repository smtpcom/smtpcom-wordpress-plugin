<?php

namespace SmtpSdk\Tests\Api\Alerts;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Alerts;
use SmtpSdk\Model\Alert;
use SmtpSdk\Response\Alerts\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

use function Couchbase\passthruEncoder;

/**
 * @Class AlertsTest
 */
class AlertsTest extends TestCase
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

        $api = $this->getApiInstance(Alerts::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(Alert::class, $response->getItems()[0]);
    }

    /**
     * @return string
     */
    public function indexProvider()
    {

        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "items": [
                    {
                        "type": "monthly_quota",
                        "threshold": "0.75",
                        "alert_id": "6b4d3be27b6fe8ab9f26d6f66901587c"
                    },
                    {
                        "type": "weeekly_quota",
                        "threshold": "0.5",
                        "alert_id": "6b4d3be27asfe8ab9f26d6f66901587c"
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

        $api = $this->getApiInstance(Alerts::class, 'channelName');
        $response = $api->show();

        $this->assertInstanceOf(Alert::class, $response);
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
                    "type": "monthly_quota",
                    "threshold": "0.75",
                    "alert_id": "6b4d3be27b6fe8ab9f26d6f66901587c"
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

        $api = $this->getApiInstance(Alerts::class, 'channelName');
        $response = $api->create(json_decode($data, true));
        print_r($response);

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

        $api = $this->getApiInstance(Alerts::class, 'channelName');
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

        $api = $this->getApiInstance(Alerts::class, 'channelName');
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
