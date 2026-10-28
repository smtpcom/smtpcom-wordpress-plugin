<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Alert;

/**
 * Class AlertTest
 */
class AlertTest extends TestCase
{
    /**
     * @param array $data
     */
    #[DataProvider('alertProvider')]
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
    public static function alertProvider()
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
