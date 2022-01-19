<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Alert;

/**
 * Class AlertTest
 */
class AlertTest extends TestCase
{
    /**
     * @dataProvider alertProvider
     * @param array $data
     */
    public function testAlert(array $data)
    {
        $alertObject = new Alert($data);

        $this->assertEquals($data, [
            "type" => $alertObject->getType(),
            "threshold" => $alertObject->getThreshold(),
            "alert_id" => $alertObject->getAlertId()
        ]);
    }

    /**
     * @return array
     */
    public function alertProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "type": "monthly_quota",
                "threshold": "0.75",
                "alert_id": "6b4d3be27b6fe8ab9f26d6f66901587c" 
            }
        }
JSON;
        return [[json_decode($json, true)['data']]];
    }
}
