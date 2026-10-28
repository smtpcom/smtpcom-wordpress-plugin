<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\DkimKey;

/**
 * Class DkimKeyTest
 */
class DkimKeyTest extends TestCase
{
    /**
     * @param array $data
     */
    #[DataProvider('dkimKeyProvider')]
    public function testDkimKey(array $data)
    {
        $dkimKeyObject = new DkimKey($data);

        $this->assertEquals($data, [
            'domain_name' => $dkimKeyObject->getDomainName(),
            'selector' => $dkimKeyObject->getSelector(),
            'private_key' => $dkimKeyObject->getPrivateKey(),
            'is_valid' => $dkimKeyObject->isIsValid()
        ]);
    }

    /**
     * @return array
     */
    public static function dkimKeyProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "domain_name": "test.com",
                "selector": "Name of the DKIM selector",
                "private_key": "Private key of the DKIM record",
                "is_valid": false
            }
        }
JSON;
        return [[json_decode($json, true)['data']]];
    }
}
