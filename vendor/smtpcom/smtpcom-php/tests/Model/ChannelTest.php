<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Channel;

/**
 * Class ChannelTest
 */

class ChannelTest extends TestCase
{
    /**
     * @dataProvider channelProvider
     * @param array $data
     */
    public function testChannel(array $data)
    {

        $channelObject = new Channel($data);

        $this->assertEquals($data, [
            'smtp_username' => $channelObject->getSmtpUsername(),
            'quota' => $channelObject->getQuota(),
            'usage' => $channelObject->getUsage(),
            'label' => $channelObject->getLabel(),
            'name' => $channelObject->getName(),
            'date_created' => date('r', $channelObject->getDateCreated()),
            'status' => $channelObject->getStatus(),
        ]);
    }

    /**
     * @return array
     */
    public function channelProvider()
    {

        $json =
            <<<'JSON'
            {
                "status": "success",
                "data": {
                    "smtp_username": "testUsername",
                    "quota": 6,
                    "usage": 0,
                    "label": "sender label",
                    "name": "testChannel",
                    "date_created": "Wed, 11 Aug 2021 14:26:20 +0000",
                    "status": "active"
                }
            }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
