<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Message;

/**
 * Class MessageTest
 */
class MessageTest extends TestCase
{
    /**
     * @dataProvider messageFullProvider
     * @param array $data
     */
    public function testMessageFull(array $data)
    {
        $messageObject = new Message($data);

        $msgData = $messageObject->getMsgData();

        $this->assertEquals($data, [
            'msg_id' => $messageObject->getMsgId(),
            'msg_time' => date('r', $messageObject->getMsgTime()),
            'channel' => $messageObject->getChannel(),
            'smtp_vars' => $messageObject->getSmtpVars(),
            'msg_data' => [
                'rcpt_to' => $msgData['rcpt_to'],
                'from' => $msgData['from'],
                'subject' => $msgData['subject']
            ],
            'details' => $messageObject->getDetails()
        ]);
    }

    /**
     * @return array
     */
    public function messageFullProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "msg_id": "d8bc7242-7492-4371-a78c-484b21a9a3eb",
                "msg_time": "Fri, 13 Aug 2021 10:24:49 +0000",
                "channel": "testVlad",
                "smtp_vars": {},
                "msg_data": {
                    "rcpt_to": "vlad@ukr.net",
                    "from": "test228@smtp.com",
                    "subject": "subject"
                },
                "details": {
                    "unsubs": {
                        "items": [
                            {
                                "unsub_time": ""
                            }
                        ]
                    },
                    "clicks": {
                        "items": [
                            {
                                "click_time": "",
                                "remote_ip": "",
                                "ua": ""
                            }
                        ]
                    },
                    "opens": {
                        "items":[
                            {
                                "open_time": "",
                                "remote_ip": "",
                                "ua": ""
                            }
                        ]
                    },
                    "abuse": {
                        "complaints": [
                            {
                                "report_time": "",
                                "provider": ""
                            }
                        ]
                    },
                    "delivery": {
                        "finished": "Fri, 13 Aug 2021 10:24:49 -0000",
                        "retries": 0,
                        "event": "delivered",
                        "code": "250",
                        "status": "OK id=1mEUMt-000IVf-VX"
                    }
                }
            }
        }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
