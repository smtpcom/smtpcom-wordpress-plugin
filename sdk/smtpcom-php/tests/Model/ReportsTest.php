<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\PeriodicReport;
use SmtpSdk\Model\OnDemandReport;
use SmtpSdk\Model\CommonReport;

/**
 * Class ReportsTest
 */
class ReportsTest extends TestCase
{
    /**
    * @dataProvider PeriodicReportProvider
    * @param array $data
    */
    public function testPeriodicReport(array $data)
    {
        $PeriodicReportObject = new PeriodicReport($data);

        $this->assertEquals($data, [
            "frequency" => $PeriodicReportObject->getFrequency(),
            "report_id" => $PeriodicReportObject->getReportId(),
            "events" => $PeriodicReportObject->getEvents(),
            "channel" => $PeriodicReportObject->getChannel(),
            "report_time" => $PeriodicReportObject->getReportTime(),
        ]);
    }

    /**
    * @return array
    */
    public function periodicReportProvider()
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
        return [[json_decode($json, true)['data']]];
    }

    /**
    * @dataProvider OnDemandReportProvider
    * @param array $data
    */
    public function testOnDemandReport(array $data)
    {

        $OnDemandReportObject = new OnDemandReport($data);

        $this->assertEquals($data, [
            "status" => $OnDemandReportObject->getStatus(),
            "name" => $OnDemandReportObject->getName(),
            "url" => $OnDemandReportObject->getUrl(),
            "time_req" => date('r', $OnDemandReportObject->getTimeReq()),
            "progress" => $OnDemandReportObject->getProgress(),
            "channel" => $OnDemandReportObject->getChannel(),
            "report_id" => $OnDemandReportObject->getReportId(),
        ]);
    }

    /**
    * @return array
    */
    public function onDemandReportProvider()
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
        return [[json_decode($json, true)['data']]];
    }

    /**
    * @dataProvider CommonReportProvider
    * @param array $data
    */
    public function testCommonReport(array $data)
    {

        $CommonReportObject = new CommonReport($data);

        $this->assertEquals($data, [
            "frequency" => $CommonReportObject->getFrequency(),
            "report_id" => $CommonReportObject->getReportId(),
            "events" => $CommonReportObject->getEvents(),
            "channel" => $CommonReportObject->getChannel(),
            "report_time" => $CommonReportObject->getReportTime(),
            "status" => $CommonReportObject->getStatus(),
            "name" => $CommonReportObject->getName(),
            "url" => $CommonReportObject->getUrl(),
            "time_req" => date('r', $CommonReportObject->getTimeReq()),
            "progress" => $CommonReportObject->getProgress()
        ]);
    }

    /**
    * @return array
    */
    public function commonReportProvider()
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
                "report_time": 2,
                "status":"active",
                "name": "testName",
                "url": "testURL.com",
                "time_req":"Wed, 07 Apr 2021 10:58:34 +0000",
                "progress":"completed"
            }
        }
JSON;
        return [[json_decode($json, true)['data']]];
    }
}
