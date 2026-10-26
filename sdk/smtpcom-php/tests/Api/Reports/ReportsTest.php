<?php

namespace SmtpSdk\Tests\Api\Reports;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Reports;
use SmtpSdk\Api\OnDemandReports;
use SmtpSdk\Api\PeriodicReports;
use SmtpSdk\Model\CommonReport;
use SmtpSdk\Model\OnDemandReport;
use SmtpSdk\Model\PeriodicReport;
use SmtpSdk\Response\Reports\IndexResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class ReportsTest
 */

class ReportsTest extends TestCase
{

    /**
     * @dataProvider indexReportsProvider
     * @param string $data
     */
    public function testReportsIndex(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Reports::class, 'channelName');
        $response = $api->index();

        $this->assertInstanceOf(IndexResponse::class, $response);

        $this->assertInstanceOf(PeriodicReport::class, $response->getPeriodic()[0]);
        $this->assertInstanceOf(OnDemandReport::class, $response->getOnDemand()[0]);
    }

    /**
     * @return string
     */
    public function indexReportsProvider()
    {

        $json =
            <<<'JSON'
            {
                "status": "success",
                "data": {
                    "periodic": [
                        {
                            "frequency": "monthly",
                            "report_id": "e535586d0649edc20c87746ab19fecc5",
                            "events": "sent",
                            "channel": "testChannel",
                            "report_time": "2"
                        },
                        {
                            "frequency": "monthly",
                            "report_id": "d26c5e3fd27474297662c75da458f59b",
                            "events": "sent",
                            "channel": "testChannel",
                            "report_time": "10"
                        }
                    ],
                    "ondemand": [
                        {
                            "status": "active",
                            "name": "testName",
                            "url": "testUrl.com",
                            "time_req":"Wed, 07 Apr 2021 10:58:34 +0000",
                            "progress":"completed",
                            "channel":"testChannel",
                            "report_id":"e535586d0649edc20c87746ab19fecc5"
                        },
                        {
                            "status": "active",
                            "name": "testName",
                            "url": "testUrl.com",
                            "time_req":"Wed, 09 Apr 2011 17:58:00 +0300",
                            "progress":"completed",
                            "channel":"testChannel",
                            "report_id":"d26c5e3fd27474297662c75da458f59b"
                        }
                    ]
                }
            }
JSON;

        return [[$json]];
    }


    /**
     * @dataProvider onDemandProvider
     * @param string $data
     */
    public function testOnDemand(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Reports::class, 'channelName');
        $response = $api->onDemand();
        $this->assertInstanceOf(OnDemandReports::class, $response);
    }

    /**
     * @return string
     */
    public function onDemandProvider()
    {
        $json =
            <<<'JSON'
        {
            "status": "success",
            "data": {
                "status": "active",
                "name": "testName",
                "url": "testURL.com",
                "time_req":"Wed, 07 Apr 2021 10:58:34 +0000",
                "progress":"completed",
                "channel":"testChannel",
                "report_id":"e535586d0649edc20c87746ab19fecc5"
            }
        }
JSON;

        return [[$json]];
    }


    /**
     * @dataProvider periodicProvider
     * @param string $data
     */
    public function testPeriodic(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Reports::class, 'channelName');
        $response = $api->periodic('e535586d0649edc20c87746ab19fecc5');
        $this->assertInstanceOf(PeriodicReports::class, $response);
    }

    /**
     * @return string
     */
    public function periodicProvider()
    {
        $json =
            <<<'JSON'
        {
            "status": "success",
            "data": {
                "frequency": "monthly",
                "report_id": "e535586d0649edc20c87746ab19fecc5",
                "events": "sent",
                "channel": "testChannel",
                "report_time": "2"
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

        $api = $this->getApiInstance(Reports::class, 'channelName');
        $response = $api->show();

        $this->assertInstanceOf(CommonReport::class, $response);
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
                "frequency": "monthly",
                "report_id": "e535586d0649edc20c87746ab19fecc5",
                "events": "sent",
                "channel": "testChannel",
                "report_time": "2",
                "status":"active",
                "name": "testName",
                "url": "testURL.com",
                "time_req":"Wed, 07 Apr 2021 10:58:34 +0000",
                "progress":"completed"
            }
        }
JSON;

        return [[$json]];
    }
}
