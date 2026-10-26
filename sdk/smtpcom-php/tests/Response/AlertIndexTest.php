<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\Alerts\IndexResponse;
use SmtpSdk\Model\Alert;

/**
 * Class AlertIndexTest
 */
class AlertIndexTest extends TestCase
{
    /**
     * @dataProvider alertProvider
     *
     * @param array $data
     */
    public function testIndex(array $data)
    {
        $responseObject = IndexResponse::create($data);

        foreach ($responseObject->getItems() as $item) {
            $this->assertInstanceOf(Alert::class, $item);
        }
        $this->assertCount(2, $responseObject->getItems());
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

        return [[json_decode($json, true)['data']]];
    }
}
