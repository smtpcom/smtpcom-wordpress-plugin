<?php

namespace SmtpSdk\Tests\Api\Account;

use GuzzleHttp\Psr7\Response;
use SmtpSdk\Api\Account;
use SmtpSdk\Model\Account as AccountModel;
use SmtpSdk\Response\Account\UpdateResponse;
use SmtpSdk\Tests\Api\TestCase;

/**
 * @Class AccountTest
*/
class AccountTest extends TestCase
{
    /**
     * @dataProvider showProvider
     * @param string $data
     */
    public function testShow(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Account::class, 'channelName');

        $response = $api->show();

        $this->assertInstanceOf(AccountModel::class, $response);
        $this->assertEquals(json_decode($data, true)['data'], [
            "status" => $response->getStatus(),
            "first_name" => $response->getFirstName(),
            "last_name" => $response->getLastName(),
            "phone" => $response->getPhone(),
            "website" => $response->getWebsite(),
            "email" => $response->getEmail(),
            "company_name" => $response->getCompanyName(),
            "usage" => $response->getUsage(),
            "date_created" => date('r', $response->getDateCreated()),
            "address" => $response->getAddress()
        ]);
    }

    /**
     * @return string
     */
    public function showProvider()
    {

        $json =
            <<<'JSON'
            {
                "status": "success",
                "data": {
                    "status": "active",
                    "first_name": "testFirstName",
                    "last_name": "testLastName",
                    "phone":"15555555555",
                    "website":"n/a",
                    "email":"testEmail@smtp.com",
                    "company_name":"testCompanyName",
                    "address":{
                        "street": "street",
                        "city": "city",
                        "state": "state",
                        "country": "CO"
                    },
                    "usage": 456,
                    "date_created": "Wed, 07 Apr 2021 10:58:34 +0000"
                }
            }
JSON;
        return [[$json]];
    }


    /**
     * @dataProvider updateProvider
     * @param string $data
     */
    public function testUpdate(string $data)
    {
        $this->setHttpResponse(new Response(
            200,
            ['Content-Type' => 'application/json'],
            $data
        ));

        $api = $this->getApiInstance(Account::class, 'channelName');

        $response = $api->update(json_decode($data, true));

        $this->assertInstanceOf(UpdateResponse::class, $response);
    }

    /**
     * @return string
     */
    public function updateProvider()
    {

        $json =
            <<<'JSON'
            {
                "status": "success",
                "data": {
                    "account":"update_status"
                }
            }
JSON;
        return [[$json]];
    }
}
