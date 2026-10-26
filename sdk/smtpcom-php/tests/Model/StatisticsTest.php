<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Statistics;

/**
 * Class StatisticsTest
 */

class StatisticsTest extends TestCase
{
    /**
    * @dataProvider statisticsProvider
    * @param array $data
    */
    public function testStatistics(array $data)
    {
        $statisticsObject = new Statistics($data);

        $this->assertEquals($data, [
            "accepted" => $statisticsObject->getAccepted(),
            "complained" => $statisticsObject->getComplained(),
            "delivered" => $statisticsObject->getDelivered(),
            "clicked" => $statisticsObject->getClicked(),
            "opened" => $statisticsObject->getOpened(),
            "failed" => $statisticsObject->getFailed(),
            "unsubscribed" => $statisticsObject->getUnsubscribed(),
            "queued" => $statisticsObject->getQueued(),
        ]);
    }

    /**
     * @return array
     */
    public function statisticsProvider()
    {

        $json =
        <<<'JSON'
        {
            "status": "success",
            "data": {
                "accepted":1805,
                "complained":0,
                "delivered":1441,
                "clicked":10,
                "opened":103,
                "failed":33,
                "unsubscribed":0,
                "queued":331
            }
        }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
