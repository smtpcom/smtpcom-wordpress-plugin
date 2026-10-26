<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Domain;

/**
 * Class DomainTest
 */
class DomainTest extends TestCase
{
    /**
     * @dataProvider domainProvider
     * @param array $data
     */
    public function testDomain(array $data)
    {
        $domainObject = new Domain($data);

        $this->assertEquals($data, [
            'domain_name' => $domainObject->getDomainName(),
            'enabled' => $domainObject->isEnabled()
        ]);
    }

    /**
     * @return array
     */
    public function domainProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "domain_name": "test.com",
                "enabled": true
            }
        }
JSON;
        return [[json_decode($json, true)['data']]];
    }
}
