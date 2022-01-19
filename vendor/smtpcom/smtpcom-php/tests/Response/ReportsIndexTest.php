<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\Reports\IndexResponse;
use SmtpSdk\Model\PeriodicReport;
use SmtpSdk\Model\OnDemandReport;

/**
 * Class ChannelIndexTest
*/
class ReportsIndexTest extends TestCase
{
    /**
     * @dataProvider chanelProvider
     * @param array $data
     */
    public function testIndex(array $data)
    {
        //Response
        $responseObject = IndexResponse::create($data);

        $this->assertCount(2, $responseObject->getPeriodic());

        $periodicItem = $responseObject->getPeriodic()[1];

        foreach ($responseObject->getPeriodic() as $item) {
            $this->assertInstanceOf(PeriodicReport::class, $item);
        }

        $this->assertEquals($data['periodic'][1], [
            "frequency" => $periodicItem->getFrequency(),
            "report_id" => $periodicItem->getReportId(),
            "events" => $periodicItem->getEvents(),
            "channel" => $periodicItem->getChannel(),
            "report_time" => $periodicItem->getReportTime(),
        ]);

        //OnDemand
        $this->assertCount(2, $responseObject->getOnDemand());

        $ondemandItem = $responseObject->getOnDemand()[0];

        foreach ($responseObject->getOnDemand() as $item) {
            $this->assertInstanceOf(OnDemandReport::class, $item);
        }

        $this->assertEquals($data['ondemand'][0], [
            "status" => $ondemandItem->getStatus(),
            "name" => $ondemandItem->getName(),
            "url" => $ondemandItem->getUrl(),
            "time_req" => date('r', $ondemandItem->getTimeReq()),
            "progress" => $ondemandItem->getProgress(),
            "channel" => $ondemandItem->getChannel(),
            "report_id" => $ondemandItem->getReportId(),
        ]);
    }

    /**
     * @return array
     */
    public function chanelProvider()
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
        return [[json_decode($json, true)['data']]];
    }
}
