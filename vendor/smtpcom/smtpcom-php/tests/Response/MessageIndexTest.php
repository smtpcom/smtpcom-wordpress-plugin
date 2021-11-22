<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\Message\IndexResponse;
use SmtpSdk\Model\Message;

/**
 * Class MessageIndexTest
 */
class MessageIndexTest extends TestCase
{
    /**
     * @dataProvider messageProvider
     *
     * @param array $data
     */
    public function testIndex(array $data)
    {
        $responseObject = IndexResponse::create($data);

        foreach ($responseObject->getItems() as $item) {
            $this->assertInstanceOf(Message::class, $item);
        }
        $this->assertCount(2, $responseObject->getItems());
    }

    /**
     * @return array
     */
    public function messageProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "items": [
                    {
                        "msg_id": "d8bc7242-7492-4371-a78c-484b21a9a3eb",
                        "msg_time": "Fri, 13 Aug 2021 10:22:49 -0000",
                        "channel": "testVlad",
                        "smtp_vars": {},
                        "msg_data": {
                            "rcpt_to": "vlad@ukr.net",
                            "from": "test228@smtp.com",
                            "subject": "subject"
                        },
                        "details": {
                            "unsubs": {
                                "items": []
                            },
                            "clicks": {
                                "items": []
                            },
                            "opens": {
                                "items":[]
                            },
                            "abuse": {
                                "complaints": []
                            },
                            "delivery": {
                                "finished": "Fri, 13 Aug 2021 10:24:49 -0000",
                                "retries": 0,
                                "event": "delivered",
                                "code": "250",
                                "status": "OK id=1mEUMt-000IVf-VX"
                            }
                        } 
                    },
                    {
                        "msg_id": "d8basd242-7492-4371-a78c-484b21a9a3eb",
                        "msg_time": "Mon, 09 Aug 2021 10:22:49 -0000",
                        "channel": "testVlad2",
                        "smtp_vars": {},
                        "msg_data": {
                            "rcpt_to": "vlad2@ukr.net",
                            "from": "test2283@smtp.com",
                            "subject": "subject2"
                        },
                        "details": {
                            "unsubs": {
                                "items": [
                                    {
                                        "unsub_time": "Time when the unsubscribe request was made"
                                    }
                                ]
                            },
                            "clicks": {
                                "items": [
                                    {
                                        "click_time": "Timestamp of when message links were clicked",
                                        "remote_ip": "IP address of where links were clicked",
                                        "ua": "User agent of device on which links were clicked"
                                    }
                                ]
                            },
                            "opens": {
                                "items":[
                                    {
                                        "open_time": "Timestamp of when the message was opened",
                                        "remote_ip": "IP address of where the message was opened",
                                        "ua": "User agent of device on which the message was opened"
                                    }
                                ]
                            },
                            "abuse": {
                                "complaints": [
                                    {
                                        "report_time": "Time when the complaint was made",
                                        "provider": "Abuse provider information"
                                    }
                                ]
                            },
                            "delivery": {
                                "finished": "Mon, 09 Aug 2021 10:24:49 -0000",
                                "retries": 0,
                                "event": "delivered",
                                "code": "250",
                                "status": "OK id=1mEUMt-000IVf-VX"
                            }
                        }
                    }
                ] 
            }
        }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
