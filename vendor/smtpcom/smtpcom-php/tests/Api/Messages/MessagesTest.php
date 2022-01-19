<?php

namespace SmtpSdk\Tests\Api\Messages;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Messages;
use SmtpSdk\Model\Message;
use SmtpSdk\Response\Message\IndexResponse;
use SmtpSdk\Response\Message\CreateResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class MessagesTest
 */

class MessagesTest extends TestCase
{
    /**
     * @dataProvider indexProvider
     * @param string $data
     */
    public function testIndex(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Messages::class, 'channelName');

        $messageData = [
            "start" => "Fri, 13 Aug 2021 10:22:49 -0000",
            "limit" => "10",
            "offset" => "0",
        ];

        $response = $api->index($messageData);

        $this->assertInstanceOf(IndexResponse::class, $response);
        $this->assertCount(2, $response->getItems());
        $this->assertInstanceOf(Message::class, $response->getItems()[0]);
    }

    /**
     * @return string
     */
    public function indexProvider()
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


        return [[$json]];
    }

    /**
     * @dataProvider createProvider
     * @param string $data
     */
    public function testCreate(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Messages::class, 'channelName');

        $response = $api->create(json_decode($data, true));

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(json_decode($data, true)['data']['message'], $response->getMessage());
    }

    /**
     * @return string
     */
    public function createProvider()
    {

        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "message":"SOME TEST DATA"
            }
        }
JSON;
        return [[$json]];
    }

    /**
     * @dataProvider createMimeProvider
     * @param string $data
     */
    public function testCreateMime(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Messages::class, 'channelName');

        $response = $api->createMime(json_decode($data, true));

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(json_decode($data, true)['data']['message'], $response->getMessage());
    }

    /**
     * @return string
     */
    public function createMimeProvider()
    {

        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "message":"SOME TEST DATA"
            }
        }
JSON;
        return [[$json]];
    }
}
