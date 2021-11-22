<?php

namespace SmtpSdk\Tests\Api\Statistics;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Statistics;
use SmtpSdk\Model\Statistics as StatisticsModel;
use SmtpSdk\Response\Statistics\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class StatisticsTest
 */

class StatisticsTest extends TestCase
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

        $api = $this->getApiInstance(Statistics::class, 'channelName');
        $response = $api->index(json_decode($data, true));

        $this->assertInstanceOf(IndexResponse::class, $response);

        $this->assertInstanceOf(StatisticsModel::class, $response->getItems()[0]);
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
                            "accepted":1805,
                            "complained":0,
                            "delivered":1441,
                            "clicked":10,
                            "opened":103,
                            "failed":33,
                            "unsubscribed":0,
                            "queued":331
                        },
                        {
                            "accepted":185,
                            "complained":1,
                            "delivered":141,
                            "clicked":1,
                            "opened":133,
                            "failed":32,
                            "unsubscribed":0,
                            "queued":371
                        }
                    ]
                }
            }
JSON;

        return [[$json]];
    }
}
