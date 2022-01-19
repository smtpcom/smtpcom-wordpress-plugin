<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Account;

/**
 * @Class AccountTest
 */

class AccountTest extends TestCase
{
    /**
    * @dataProvider accountProvider
    * @param array $data
    */
    public function testAccount(array $data)
    {
        $accountObject = new Account($data);

        $this->assertEquals($data, [
            "status" => $accountObject->getStatus(),
            "first_name" => $accountObject->getFirstName(),
            "last_name" => $accountObject->getLastName(),
            "phone" => $accountObject->getPhone(),
            "website" => $accountObject->getWebsite(),
            "email" => $accountObject->getEmail(),
            "company_name" => $accountObject->getCompanyName(),
            "usage" => $accountObject->getUsage(),
            "date_created" => date('r', $accountObject->getDateCreated()),
            "address" => $accountObject->getAddress()
        ]);
    }


    /**
    * @return array
    */
    public function accountProvider()
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

        return [[json_decode($json, true)['data']]];
    }
}
