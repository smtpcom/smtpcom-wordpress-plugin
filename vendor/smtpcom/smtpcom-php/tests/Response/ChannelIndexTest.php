<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\Channels\IndexResponse;
use SmtpSdk\Model\Channel;

/**
 * Class ChannelIndexTest
 */
class ChannelIndexTest extends TestCase
{
    /**
     * @dataProvider chanelProvider
     * @param int $count
     * @param array $data
     */
    public function testIndex(array $data)
    {
        $channelObject = IndexResponse::create($data);

        $this->assertCount(2, $channelObject->getItems());

        foreach ($channelObject->getItems() as $item) {
            $this->assertInstanceOf(Channel::class, $item);
        }

        $item = $channelObject->getItems()[1];

        $this->assertEquals($data['items'][1], [
            'smtp_username' => $item->getSmtpUsername(),
            'quota' => $item->getQuota(),
            'usage' => $item->getUsage(),
            'label' => $item->getLabel(),
            'name' => $item->getName(),
            'date_created' => date('r', $item->getDateCreated()),
            'status' => $item->getStatus(),
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
                    "items": [
                        {
                            "smtp_username": "testUser",
                            "quota": 5,
                            "usage": 1,
                            "label": "label1",
                            "name": "testName",
                            "date_created": "Wed, 11 Aug 2019 14:08:09 -0000",
                            "status": "active"
                        },
                        {
                            "smtp_username": "testUser2",
                            "quota": null,
                            "usage": 183,
                            "label": "label2",
                            "name": "name_test",
                            "date_created": "Wed, 07 Apr 2021 11:05:34 +0000",
                            "status": "inactive"
                        }
                    ]
                }
            }
JSON;
        return [[json_decode($json, true)['data']]];
    }
}
